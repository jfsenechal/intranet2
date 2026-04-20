# Agent Module — Filament Blueprint

Module that manages **agent (staff) profiles** and their **IT provisioning**: mailbox access, external-application access, shared-folder access, hardware requests, telephony setup, audit history and external sharing of the profile.

Source dataset: `data/agent.sql` (legacy Symfony application, database `agent`).

- **Namespace:** `AcMarche\Agent`
- **DB connection:** `maria-agent` → database `agent`
- **Filament panel:** `app-panel` (existing `/app`)
- **Navigation group:** `Gestion des agents`
- **Module id (Security):** `40` (matches legacy "Agent" entry)

---

## 1. Commands

```bash
# once (after composer.json update)
composer update acmarche/agent

# migrations (renames legacy tables where they exist)
php artisan migrate --database=maria-agent --path=modules/Agent/database/migrations

# Filament scaffolding (run one by one)
php artisan make:filament-resource Agent \
    --model=AcMarche\\Agent\\Models\\Agent \
    --view --generate --no-interaction
php artisan make:filament-resource ExternalApplication \
    --model=AcMarche\\Agent\\Models\\ExternalApplication \
    --view --generate --no-interaction
php artisan make:filament-resource Folder \
    --model=AcMarche\\Agent\\Models\\Folder \
    --view --generate --no-interaction

# Relation managers (attach to AgentResource)
php artisan make:filament-relation-manager AgentResource hardware
php artisan make:filament-relation-manager AgentResource phone
php artisan make:filament-relation-manager AgentResource externalApplications name
php artisan make:filament-relation-manager AgentResource folders name
php artisan make:filament-relation-manager AgentResource histories name --view
php artisan make:filament-relation-manager AgentResource shares shared_for
```

After scaffolding, move generated classes from `app/Filament/…` into
`modules/Agent/src/Filament/Resources/…` and update namespaces to
`AcMarche\Agent\Filament\Resources\*` (see existing modules as reference).

---

## 2. Models

All live under `AcMarche\Agent\Models` with `#[Connection('maria-agent')]`.

### `Agent`
Main profile record for a staff member.

| Attribute      | Type     | Notes                                    |
| -------------- | -------- | ---------------------------------------- |
| `id`           | bigint   |                                          |
| `last_name`    | string   | required                                 |
| `first_name`   | string   | required                                 |
| `emails`       | json     | array of shared mailbox addresses        |
| `supervisors`  | json     | array (string list)                      |
| `location`     | string   | nullable (physical office)               |
| `notes`        | longText | nullable                                 |
| `modules`      | json     | array of Security `modules.id` values    |
| `employee_id`  | int      | nullable — FK into `hrm.employees`       |
| `uuid`         | uuid     |                                          |
| `username`     | string   | nullable — AD login when provisioned     |
| `no_mail`      | bool     | "no personal mailbox" flag               |
| `timestamps`   |          |                                          |
| `deleted_at`   | softDel  |                                          |

Relationships: `hasOne AgentHardware`, `hasOne AgentPhone`,
`belongsToMany ExternalApplication` (pivot `agent_external_application`),
`belongsToMany Folder` (pivot `agent_folder`), `hasMany History`, `hasMany Share`.
Accessor: `full_name` → `"{first_name} {last_name}"`.
Uses `HasUserAdd` booted trait (legacy naming kept).

### `ExternalApplication`
Catalog of third-party applications the agent may need (Civadis, Saphir, eComptes, …).

| Attribute       | Type     |
| --------------- | -------- |
| `id`            | bigint   |
| `name`          | string   |
| `description`   | longText |
| `service_id`    | int      |
| `timestamps`    |          |

`belongsToMany Agent`.

### `Folder`
Self-referential tree of shared network folders (one DFS path per node).

| Attribute      | Type     |
| -------------- | -------- |
| `id`           | bigint   |
| `parent_id`    | fk→folders (cascade) |
| `name`         | string   |
| `description`  | longText |
| `timestamps`   |          |

`belongsTo parent`, `hasMany children`, `belongsToMany Agent`.

### `AgentHardware` (table `agent_hardware`)
1:1 hardware request per agent.

| Attribute       | Type     |
| --------------- | -------- |
| `agent_id`      | fk→agents |
| `existing_pc`   | string nullable |
| `new_pc`        | string nullable |
| `other`         | longText |
| `vpn`           | bool     |

### `AgentPhone` (table `agent_phone`)
1:1 telephony request per agent.

| Attribute         | Type     |
| ----------------- | -------- |
| `agent_id`        | fk→agents |
| `existing_number` | string   |
| `new_number`      | bool     |
| `external_number` | bool     |
| `mobile_number`   | string   |

### `History`
Append-only audit trail. Every edit writes one row.

| Attribute     | Type   |
| ------------- | ------ |
| `agent_id`    | fk     |
| `name`        | string (attribute name: `email`, `responsables`, `dossier`, …) |
| `old_value`   | json   |
| `new_value`   | json   |
| `username`    | string (author) |
| `timestamps`  |        |

### `Share`
An email address the agent profile has been "shared for review" with.

| Attribute    | Type   |
| ------------ | ------ |
| `agent_id`   | fk     |
| `shared_by`  | string (username) |
| `shared_for` | string (email)    |

### Pivots (no model)
`agent_external_application (agent_id, external_application_id)`
`agent_folder (agent_id, folder_id)`

---

## 3. Resources

### 3.1 `AgentResource`
- **Location:** `modules/Agent/src/Filament/Resources/Agents/AgentResource.php`
- **Navigation group:** `Gestion des agents`
- **Navigation icon:** `heroicon-o-identification`
- **Navigation label:** `Agents`
- **Record title attribute:** `full_name`

**Form** (`Schemas/AgentForm`):

Use a `Filament\Schemas\Components\Tabs` layout with these tabs:

1. **Identité**
   - `TextInput::make('last_name')` — required, maxLength 255
   - `TextInput::make('first_name')` — required, maxLength 255
   - `TextInput::make('username')` — nullable, alphaDash
   - `TextInput::make('employee_id')` — numeric, nullable, Select `Employee` (via `AcMarche\Hrm\Models\Employee`) if available
   - `Toggle::make('no_mail')`
   - `TextInput::make('location')`
   - `Textarea::make('notes')` → columnSpanFull
2. **Accès**
   - `TagsInput::make('emails')` — "Boîtes mails à partager"
   - `TagsInput::make('supervisors')` — "Responsables"
   - `Select::make('modules')` — multiple, options from `\AcMarche\Security\Models\Module::query()->pluck('name','id')`
   - `Select::make('externalApplications')` — `relationship('externalApplications', 'name')` multiple + preload + searchable
   - `Select::make('folders')` — `relationship('folders', 'name')` multiple + preload + searchable
3. **Matériel** (`Filament\Schemas\Components\Section`)
   - Edit through relation manager; on create show `Fieldset` with:
     `TextInput existing_pc`, `TextInput new_pc`, `Textarea other`, `Toggle vpn`
4. **Téléphonie**
   - `TextInput existing_number`, `Toggle new_number`, `Toggle external_number`, `TextInput mobile_number`

**Table** (`Tables/AgentsTable`):

| Column              | Class                                              | Notes                    |
| ------------------- | -------------------------------------------------- | ------------------------ |
| `last_name`         | `Filament\Tables\Columns\TextColumn`               | sortable, searchable     |
| `first_name`        | idem                                               | sortable, searchable     |
| `username`          | idem                                               | copyable, badge          |
| `employee_id`       | idem                                               | toggleable, hidden default |
| `externalApplications_count` | `TextColumn::make('external_applications_count')->counts('externalApplications')` | |
| `folders_count`     | same pattern                                       |                          |
| `no_mail`           | `IconColumn`                                       |                          |
| `updated_at`        | `TextColumn` since                                 |                          |

Filters:
- `Filament\Tables\Filters\TernaryFilter::make('no_mail')`
- `SelectFilter::make('externalApplications')->relationship('externalApplications','name')->multiple()`
- `TrashedFilter::make()`

Row actions: `ViewAction`, `EditAction`, `DeleteAction`, `RestoreAction`, `ForceDeleteAction`.
Header action: `CreateAction`.
Bulk: `DeleteBulkAction`, `RestoreBulkAction`.

**Pages** (`Pages/…`):
- `ListAgents` (index)
- `CreateAgent`
- `EditAgent`
- `ViewAgent`

**Relation managers** (attached to `AgentResource::getRelations()`):
- `HardwareRelationManager` (hasOne — use `Forms` only)
- `PhoneRelationManager` (hasOne)
- `ExternalApplicationsRelationManager` (belongsToMany, attach/detach, searchable)
- `FoldersRelationManager` (belongsToMany, attach/detach, tree-aware hint showing `parent.name` path)
- `HistoriesRelationManager` (readonly: disable create/edit/delete, show diff of `old_value` / `new_value`)
- `SharesRelationManager` (create with `shared_for` email, auto-fill `shared_by` with `auth()->user()->username`)

**Observer** (`AcMarche\Agent\Observers\AgentObserver`):
On `updated`, iterate `$agent->getChanges()` and write a row to `histories` for each changed attribute. Register via `#[ObservedBy]` on `Agent`.

### 3.2 `ExternalApplicationResource`
- **Location:** `modules/Agent/src/Filament/Resources/ExternalApplications/ExternalApplicationResource.php`
- Fields: `name` (required, unique), `description` (Textarea), `service_id` (Select pointing to existing Service model if relevant).
- Table: `name`, `agents_count`, `created_at`.
- Pages: Create / Edit / View / List.

### 3.3 `FolderResource`
- **Location:** `modules/Agent/src/Filament/Resources/Folders/FolderResource.php`
- Tree-like list using `parent.name` breadcrumb, or use `kalnoy/nestedset` if ever added — for now use a `TextColumn` showing full path built in a model accessor.
- Fields: `Select parent_id` (self-relation, searchable, nullable), `TextInput name`, `Textarea description`.
- Table: `name`, `parent.name`, `agents_count`.

---

## 4. Authorization

For phase 1 authorization is role-based via the existing `AcMarche\Security` module:

| Action  | Allowed role(s)           |
| ------- | ------------------------- |
| viewAny | `module:40 viewer`        |
| view    | viewer                    |
| create  | `module:40 editor`        |
| update  | editor                    |
| delete  | editor                    |
| restore | `module:40 admin`         |
| forceDelete | admin                 |

Implement policies under `modules/Agent/src/Policies/{Agent,ExternalApplication,Folder}Policy.php` and register via `Gate::policy()` in `AgentServiceProvider::boot()`.

`HistoryPolicy` / `SharePolicy` — read-only for non-admins; history has no update/delete.

---

## 5. Widgets (optional, phase 2)

- `AgentsOverview` (StatsOverviewWidget):
  - `Total agents` — `Agent::count()`
  - `Sans mailbox` — `Agent::where('no_mail', true)->count()`
  - `Partagés cette semaine` — `Share::where('created_at', '>=', now()->subWeek())->count()`
- `ApplicationsUsageChart` (BarChartWidget): top 10 external applications by assigned agents.

Placement: on `ListAgents::getHeaderWidgets()` or a new `AgentsDashboard` page.

---

## 6. Tests (Pest)

Feature tests under `modules/Agent/tests/Feature/`:

1. `AgentResourceTest.php`
   - `it lists agents` → `livewire(ListAgents::class)->assertCanSeeTableRecords($agents)`
   - `it creates an agent` (fill form → `assertDatabaseHas('agents', …)`)
   - `it updates an agent and writes history` → assert a row in `histories`
   - `it soft deletes an agent`
2. `ExternalApplicationResourceTest.php` — CRUD happy path
3. `FolderResourceTest.php` — CRUD + parent/child selection
4. `AgentRelationsTest.php`
   - attach/detach external applications
   - attach/detach folders
   - hasOne hardware upsert
   - hasOne phone upsert
5. `ShareTest.php`
   - creating a share auto-fills `shared_by`
6. `Unit/AgentObserverTest.php`
   - updating `emails` produces a history row with correct `old_value`/`new_value`

Factories required under `modules/Agent/database/factories/`:
`AgentFactory`, `ExternalApplicationFactory`, `FolderFactory`, `AgentHardwareFactory`,
`AgentPhoneFactory`, `HistoryFactory`, `ShareFactory`.

---

## 7. Styling

- **Icons (Heroicons):** Agents `identification`, External Applications `puzzle-piece`, Folders `folder`, Hardware `computer-desktop`, Phone `phone`, Histories `clock`, Shares `share`.
- **Colors:** `primary` for active, `gray` for soft-deleted rows, `warning` on `no_mail = true`.

---

## 8. Pre-submission checklist

- [ ] `composer update acmarche/agent` done
- [ ] `php artisan migrate --database=maria-agent` clean on a fresh DB **and** on a legacy `agent` DB
- [ ] `AgentServiceProvider` discovered by Laravel package discovery
- [ ] `AgentResource` appears in `/app` panel under "Gestion des agents"
- [ ] Every list/relation manager eager-loads counts to avoid N+1
- [ ] `vendor/bin/pint --dirty --format agent` clean
- [ ] `php artisan test --compact --filter=Agent` green
