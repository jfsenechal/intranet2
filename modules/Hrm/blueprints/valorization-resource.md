# Blueprint — ValorizationResource (HRM, Filament v5)

> Implementation specification for the missing `ValorizationResource` in the
> `AcMarche\Hrm` module. The model, migration, policy, and `RelationManager`
> already exist — only the Resource, its Pages, its Form/Infolist schemas, and
> the missing `configure()` method on the existing `ValorizationTables` class
> need to be added. One small wiring bug in `ViewEmployee.php` must also be
> fixed.

## 1. Pre-conditions (already in place — DO NOT recreate)

| Asset | Path |
| --- | --- |
| Model | `AcMarche\Hrm\Models\Valorization` (final, connection `maria-hrm`, table `valorizations`) |
| Policy | `AcMarche\Hrm\Policies\ValorizationPolicy` (admin-only — keep as-is) |
| Migration | `modules/Hrm/database/migrations/2024_01_01_000008_create_hrm_remaining_tables.php` (block "Valorisations") |
| Relation manager | `AcMarche\Hrm\Filament\Resources\Employees\RelationManagers\ValorizationsRelationManager` (read-only) |
| Existing tables file | `AcMarche\Hrm\Filament\Resources\Valorizations\Tables\ValorizationTables` (has `relation()`; needs new `configure()`) |

The model exposes the relation `employee(): BelongsTo<Employee>` and is
fillable on: `employee_id, employer_name, duration, regime, content,
file_name, updated_by`.

The DB columns are:
- `id` (auto)
- `employee_id` (foreignId, nullable)
- `employer_name` (string 150, NOT NULL)
- `duration` (string 150, NOT NULL)
- `regime` (string 150, nullable) — **kept as free-form string, no `%` suffix**
- `content` (longText, nullable)
- `file_name` (string 255, nullable) — used as the attestation file path
- `updated_by` (string 255, nullable)
- timestamps

## 2. Commands

**No scaffold command for the model/migration** — they exist already.
Generate the Resource scaffolding manually because the existing folder
`modules/Hrm/src/Filament/Resources/Valorizations/` already holds
`Tables/ValorizationTables.php`. Create files by hand, mirroring
`Trainings/` and `Diplomas/` (same module, same conventions).

Run for verification only:

```
php artisan route:list --path=hrm/valorizations
```

## 3. Config change

Edit `modules/Hrm/config/hrm.php` and add a new key inside the `uploads`
array:

```
'valorizations' => 'uploads/hrm/valorizations',
```

Place it next to the existing `formations` / `diplomas` keys so the order
stays grouped. This is what `FileUpload::directory()` will reference.

## 4. Resource

```
Resource: ValorizationResource
  Location: AcMarche\Hrm\Filament\Resources\Valorizations\ValorizationResource
  File:     modules/Hrm/src/Filament/Resources/Valorizations/ValorizationResource.php
  Docs:     https://filamentphp.com/docs/5.x/panels/resources/overview

  Model:               AcMarche\Hrm\Models\Valorization
  RecordTitleAttribute: employer_name

  Class declaration:
    final class ValorizationResource extends Resource
    Mirror the property declarations used in TrainingResource / DiplomaResource:
      #[Override] protected static ?string $model = Valorization::class;
      #[Override] protected static string|null|UnitEnum $navigationGroup = 'Personnel';
      #[Override] protected static ?int $navigationSort = 10;
    (Use UnitEnum import — same as TrainingResource.)

  Navigation:
    Group: Personnel
    Label: Valorisations
    Plural label: Valorisations
    Singular label: Valorisation
    Icon: heroicon-o-currency-euro
    Sort: 10
    Use string icons via getNavigationIcon() (matches TrainingResource convention,
    not the Heroicon enum, since the existing siblings return string).

  Pages (registered via getPages()):
    'index'  => ListValorizations::route('/')
    'create' => CreateValorization::route('/create')
    'view'   => ViewValorization::route('/{record}/view')
    'edit'   => EditValorization::route('/{record}/edit')

  Form:    delegate to ValorizationForm::configure($schema)     (see §5)
  Infolist: delegate to ValorizationInfolist::configure($schema) (see §6)
  Table:   delegate to ValorizationTables::configure($table)    (see §7)
```

The created/edited records redirect to the `view` page automatically — that
behaviour is already configured globally on the panel
(`HrmPanelProvider::resourceCreatePageRedirect('view')`).

## 5. Form schema

```
File: modules/Hrm/src/Filament/Resources/Valorizations/Schemas/ValorizationForm.php
Class: AcMarche\Hrm\Filament\Resources\Valorizations\Schemas\ValorizationForm
Method: public static function configure(Schema $schema): Schema

Schema:
  Columns: 1
  Section "Valorisation":
    Columns: 2

    Field: employee_id
      Component: Filament\Forms\Components\Select
      Docs: https://filamentphp.com/docs/5.x/forms/select
      Validation: required, exists on Employee
      Config:
        ->relationship('employee', 'last_name')
        ->getOptionLabelFromRecordUsing(fn (Employee $record): string => $record->last_name.' '.$record->first_name)
        ->searchable(['last_name', 'first_name'])
        ->preload()
        ->required()
      Note: when arriving with ?employee_id=… in the URL, CreateValorization::fillForm()
            pre-fills this field (see §8).

    Field: employer_name
      Component: Filament\Forms\Components\TextInput
      Docs: https://filamentphp.com/docs/5.x/forms/text-input
      Validation: required, max:150
      Config: ->label('Employeur'), ->required(), ->maxLength(150)

    Field: duration
      Component: Filament\Forms\Components\TextInput
      Docs: https://filamentphp.com/docs/5.x/forms/text-input
      Validation: required, max:150
      Config: ->label('Durée'), ->required(), ->maxLength(150)
              (free-form text — e.g. "3 ans", "12 mois")

    Field: regime
      Component: Filament\Forms\Components\TextInput
      Docs: https://filamentphp.com/docs/5.x/forms/text-input
      Validation: nullable, max:150
      Config: ->label('Régime'), ->maxLength(150)
              (free-form string — NO suffix, NO numeric())

  Section "Contenu":
    Columns: 1

    Field: content
      Component: Filament\Forms\Components\RichEditor
      Docs: https://filamentphp.com/docs/5.x/forms/rich-editor
      Validation: nullable
      Config: ->label('Contenu'), ->hiddenLabel(), ->columnSpanFull()

  Section "Attestation":
    Columns: 1

    Field: file_name
      Component: Filament\Forms\Components\FileUpload
      Docs: https://filamentphp.com/docs/5.x/forms/file-upload
      Validation: nullable, file
      Config:
        ->label('Fichier attestation')
        ->disk('public')
        ->visibility('public')
        ->directory(config('hrm.uploads.valorizations'))
        ->columnSpanFull()
```

Imports for the form file:

```
use AcMarche\Hrm\Models\Employee;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
```

## 6. Infolist (View page)

```
File: modules/Hrm/src/Filament/Resources/Valorizations/Schemas/ValorizationInfolist.php
Class: AcMarche\Hrm\Filament\Resources\Valorizations\Schemas\ValorizationInfolist
Method: public static function configure(Schema $schema): Schema

Schema:
  Columns: 3

  Grid (columnSpan 2, columns 1):
    Section "Valorisation" (columns 2):
      Entry: employer_name
        Component: Filament\Infolists\Components\TextEntry
        Docs: https://filamentphp.com/docs/5.x/infolists/text-entry
        Config: ->label('Employeur')
      Entry: duration
        Component: Filament\Infolists\Components\TextEntry
        Config: ->label('Durée')
      Entry: regime
        Component: Filament\Infolists\Components\TextEntry
        Config: ->label('Régime'), ->placeholder('—')

    Section "Contenu":
      Entry: content
        Component: Filament\Infolists\Components\TextEntry
        Config: ->label('Contenu'), ->hiddenLabel(), ->html(), ->prose(), ->columnSpanFull()

    Section "Attestation":
      Entry: file_name
        Component: Filament\Infolists\Components\TextEntry
        Config:
          ->label('Fichier attestation')
          ->placeholder('—')
          ->icon('heroicon-o-arrow-down-tray')
          ->formatStateUsing(fn (?string $state): ?string => $state ? 'Télécharger' : null)
          ->url(fn (?string $state): ?string => $state ? Storage::disk('public')->url($state) : null)
          ->openUrlInNewTab()

  Section "Métadonnées" (columnSpan 1):
    Entry: employee.last_name
      Component: Filament\Infolists\Components\TextEntry
      Config: ->label('Agent'),
              ->formatStateUsing(fn ($state, Valorization $record): string =>
                  $record->employee?->last_name.' '.$record->employee?->first_name)
    Entry: created_at
      Component: Filament\Infolists\Components\TextEntry
      Config: ->label('Créé le'), ->date('d/m/Y')
    Entry: updated_by
      Component: Filament\Infolists\Components\TextEntry
      Config: ->label('Modifié par'), ->placeholder('—')
    Entry: updated_at
      Component: Filament\Infolists\Components\TextEntry
      Config: ->label('Modifié le'), ->date('d/m/Y')
```

Imports:

```
use AcMarche\Hrm\Models\Valorization;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
```

## 7. Table — extend the existing class

Modify `modules/Hrm/src/Filament/Resources/Valorizations/Tables/ValorizationTables.php`.
**Keep the existing `relation()` method untouched** (the relation manager
depends on it). Add a new `configure()` method:

```
Method: public static function configure(Table $table): Table
  ->defaultSort('created_at', 'desc')
  ->defaultPaginationPageOption(50)
  Columns:
    Column: employee.last_name
      Component: Filament\Tables\Columns\TextColumn
      Docs: https://filamentphp.com/docs/5.x/tables/columns/text
      Config:
        ->label('Agent')
        ->formatStateUsing(fn (Valorization $record): string =>
            $record->employee->last_name.' '.$record->employee->first_name)
        ->searchable(['last_name', 'first_name'])
        ->sortable()

    Column: employer_name
      Component: Filament\Tables\Columns\TextColumn
      Config: ->label('Employeur'), ->searchable(), ->sortable()

    Column: duration
      Component: Filament\Tables\Columns\TextColumn
      Config: ->label('Durée'), ->sortable()

    Column: regime
      Component: Filament\Tables\Columns\TextColumn
      Config: ->label('Régime'), ->sortable(), ->toggleable()

    Column: content
      Component: Filament\Tables\Columns\TextColumn
      Config: ->label('Contenu'), ->limit(60), ->toggleable()

    Column: file_name
      Component: Filament\Tables\Columns\TextColumn
      Config: ->label('Fichier'),
              ->formatStateUsing(fn (?string $state): string => $state ? '✓' : '—'),
              ->toggleable()

    Column: created_at
      Component: Filament\Tables\Columns\TextColumn
      Config: ->label('Créé le'), ->date('d/m/Y'), ->sortable(),
              ->toggleable(isToggledHiddenByDefault: true)

  Filters: (none)

  Record actions:
    Filament\Actions\ViewAction::make(),
    Filament\Actions\EditAction::make(),
  ->recordAction(ViewAction::class)

  Toolbar actions:
    Filament\Actions\BulkActionGroup::make([
        Filament\Actions\DeleteBulkAction::make(),
    ]),
```

Add imports as needed (Valorization model, ViewAction, EditAction,
BulkActionGroup, DeleteBulkAction, TextColumn). The `relation()` method
already imports what it needs — leave it alone.

## 8. Pages

Mirror `Diplomas/Pages/*.php` and `Trainings/Pages/*.php` — same patterns,
same `BackToEmployeeAction`, same `getEmployeeFromQuery()` shortcut.

### 8.1 ListValorizations

```
File: modules/Hrm/src/Filament/Resources/Valorizations/Pages/ListValorizations.php
Class: final class ListValorizations extends ListRecords

Body:
  #[Override]
  protected static string $resource = ValorizationResource::class;

  public function getTitle(): string|Htmlable
  {
      return $this->getAllTableRecordsCount().' valorisations';
  }
```

### 8.2 CreateValorization

```
File: modules/Hrm/src/Filament/Resources/Valorizations/Pages/CreateValorization.php
Class: final class CreateValorization extends CreateRecord

Body:
  #[Override]
  protected static string $resource = ValorizationResource::class;

  public function getTitle(): string|Htmlable
  {
      if ($employee = $this->getEmployeeFromQuery()) {
          return 'Ajouter une valorisation pour '.$employee->last_name.' '.$employee->first_name;
      }
      return 'Ajouter une valorisation';
  }

  protected function fillForm(): void
  {
      $data = [];
      if ($employee = $this->getEmployeeFromQuery()) {
          $data['employee_id'] = $employee->id;
      }
      $this->form->fill($data);
  }

  private function getEmployeeFromQuery(): ?Employee
  {
      $employeeId = request()->query('employee_id');
      return $employeeId ? Employee::find($employeeId) : null;
  }
```

### 8.3 EditValorization

```
File: modules/Hrm/src/Filament/Resources/Valorizations/Pages/EditValorization.php
Class: final class EditValorization extends EditRecord

Body:
  #[Override]
  protected static string $resource = ValorizationResource::class;

  public function getTitle(): string|Htmlable
  {
      return 'Modification valorisation de '
          .$this->record->employee->last_name.' '.$this->record->employee->first_name;
  }

  protected function getHeaderActions(): array
  {
      return [
          ViewAction::make()->icon(Heroicon::Eye),
      ];
  }
```

### 8.4 ViewValorization

```
File: modules/Hrm/src/Filament/Resources/Valorizations/Pages/ViewValorization.php
Class: final class ViewValorization extends ViewRecord

Body:
  #[Override]
  protected static string $resource = ValorizationResource::class;

  public function getTitle(): string|Htmlable
  {
      return $this->record->employer_name
          .' de '.$this->record->employee->last_name
          .' '.$this->record->employee->first_name;
  }

  protected function getHeaderActions(): array
  {
      return [
          BackToEmployeeAction::make(),
          EditAction::make()->icon(Heroicon::Pencil),
          DeleteAction::make()->icon(Heroicon::Trash),
      ];
  }
```

`BackToEmployeeAction` lives at `AcMarche\Hrm\Filament\Actions\BackToEmployeeAction`
and is the same one used by `ViewDiploma` and `ViewTraining`.

## 9. Wire-up — fix ViewEmployee

`modules/Hrm/src/Filament/Resources/Employees/Pages/ViewEmployee.php` has a
bug at lines 60–63: the "Ajouter une valorisation" action currently builds
its URL from `DiplomaResource::getUrl(...)` instead of the (missing)
`ValorizationResource`. Once the resource exists:

1. Add the import:
   `use AcMarche\Hrm\Filament\Resources\Valorizations\ValorizationResource;`
2. Replace the action URL:
   ```
   Action::make('addValorization')
       ->label('Ajouter une valorisation')
       ->icon('tabler-plus')
       ->url(ValorizationResource::getUrl('create', $employeeId)),
   ```

## 10. RelationManager — leave as-is

`ValorizationsRelationManager` is read-only and already calls
`ValorizationTables::relation($table)`. **Do not modify it** unless you
also intend to enable inline create/edit, which is out of scope here.

## 11. Authorization

The existing `ValorizationPolicy` is the source of truth — do **not**
re-write it. Behaviour summary (already implemented):

| Ability | Rule |
| --- | --- |
| `viewAny` | admin only |
| `view`    | admin OR `canViewEmployee($user, $valorization->employee)` |
| `create`  | admin only |
| `update`  | admin only |
| `delete`  | admin only |
| `restore` | admin only |
| `forceDelete` | always false |

Filament v5 auto-discovers the policy via `Policy::class` resolution; no
manual registration needed (verify `AuthServiceProvider` only if a test
fails on authorization — none of the existing HRM resources register
policies manually).

## 12. Tests

Create `modules/Hrm/tests/Feature/Filament/ValorizationResourceTest.php`
(Pest, mirroring sibling Filament tests). Use `RefreshDatabase` is **not**
appropriate here because the model uses the `maria-hrm` connection — copy
whatever bootstrap pattern other HRM Filament tests use; if none exist
yet, add the test but mark it `->skip()` with a TODO so CI stays green
until a DB-bootstrap helper is added.

Cases to cover at minimum:

- `it lists valorizations on the index page`
  - Authenticate an admin user, seed 3 `Valorization` rows via factory,
    assert `livewire(ListValorizations::class)->assertCanSeeTableRecords($rows)`.
- `it pre-fills employee_id from the query string on create`
  - Visit `CreateValorization::getUrl(['employee_id' => $employee->id])`,
    assert the form state contains `employee_id => $employee->id`.
- `it requires employee_id, employer_name, duration`
  - `livewire(CreateValorization::class)->fillForm([...])->call('create')->assertHasFormErrors([...])`.
- `it creates a valorization`
  - Fill the form, call `create`, assert redirect + `assertDatabaseHas('valorizations', [...])`.
- `non-admin users cannot view the index`
  - Authenticate as a non-admin user, call `livewire(ListValorizations::class)`,
    assert `Response::HTTP_FORBIDDEN` (or whatever convention the existing
    HRM tests use).

If a `ValorizationFactory` does not exist yet, generate it via
`php artisan make:factory ValorizationFactory --model="AcMarche\\Hrm\\Models\\Valorization" --no-interaction`
and define states for: `employer_name` (faker company), `duration` (e.g.
"3 ans"), `regime` (e.g. "100%"), `content` (faker paragraph),
`employee_id` (Employee factory).

Run the suite focused on the new file:

```
php artisan test --compact --filter=ValorizationResourceTest
```

## 13. Final checklist for the implementing agent

- [ ] Add `'valorizations' => 'uploads/hrm/valorizations'` to `config/hrm.php`.
- [ ] Create `ValorizationResource.php` (matches §4).
- [ ] Create `Schemas/ValorizationForm.php` (matches §5).
- [ ] Create `Schemas/ValorizationInfolist.php` (matches §6).
- [ ] Add `configure()` method to existing `Tables/ValorizationTables.php` (matches §7) — leave `relation()` as-is.
- [ ] Create `Pages/ListValorizations.php`, `Pages/CreateValorization.php`,
      `Pages/EditValorization.php`, `Pages/ViewValorization.php` (matches §8).
- [ ] Patch `Resources/Employees/Pages/ViewEmployee.php` so the
      `addValorization` action points at `ValorizationResource` (matches §9).
- [ ] Add the feature test file from §12 (skip cases that need a DB bootstrap
      helper if none exists, with a TODO note).
- [ ] Run `vendor/bin/pint --dirty --format agent`.
- [ ] Run `php artisan test --compact --filter=ValorizationResourceTest`.
- [ ] Smoke-check the panel:
      `php artisan route:list --path=hrm/valorizations`
      should list `index`, `create`, `view`, `edit` routes.
