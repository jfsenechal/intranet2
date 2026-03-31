<?php

declare(strict_types=1);

use AcMarche\Mileage\Enums\RolesEnum;
use AcMarche\Mileage\Filament\Resources\Declarations\Pages\CreateDeclaration;
use AcMarche\Mileage\Filament\Resources\Declarations\Pages\EditDeclaration;
use AcMarche\Mileage\Filament\Resources\Declarations\Pages\ListDeclarations;
use AcMarche\Mileage\Filament\Resources\Declarations\Pages\ViewDeclaration;
use AcMarche\Mileage\Models\BudgetArticle;
use AcMarche\Mileage\Models\Declaration;
use AcMarche\Mileage\Models\PersonalInformation;
use AcMarche\Security\Models\Role;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('mileage-panel'));
    $this->user = User::factory()->create(['username' => 'aaguirre', 'is_administrator' => true]);
    $role = Role::factory()->create(['name' => RolesEnum::ROLE_FINANCE_DEPLACEMENT_ADMIN->value]);
    $this->user->roles()->attach($role);
    PersonalInformation::factory()->create(['username' => 'aaguirre']);
    $this->actingAs($this->user);
});

it('can render the index page', function () {
    livewire(ListDeclarations::class)
        ->assertOk();
});

it('can render the create page', function () {
    BudgetArticle::factory()->create();

    livewire(CreateDeclaration::class)
        ->assertOk();
});

it('can render the view page', function () {
    $declaration = Declaration::factory()->create(['user_add' => 'aaguirre']);

    livewire(ViewDeclaration::class, ['record' => $declaration->id])
        ->assertOk();
});

it('can render the edit page', function () {
    $declaration = Declaration::factory()->create(['user_add' => 'aaguirre']);

    livewire(EditDeclaration::class, ['record' => $declaration->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'last_name' => $declaration->last_name,
            'first_name' => $declaration->first_name,
            'iban' => $declaration->iban,
        ]);
});

it('can list declarations', function () {
    $declarations = Declaration::factory(3)->create(['user_add' => 'aaguirre']);

    livewire(ListDeclarations::class)
        ->loadTable()
        ->assertCanSeeTableRecords($declarations);
});

it('has table columns', function (string $column) {
    livewire(ListDeclarations::class)
        ->assertTableColumnExists($column);
})->with(['last_name', 'first_name', 'type_movement']);

it('can search declarations', function () {
    $declarations = Declaration::factory(5)->create(['user_add' => 'aaguirre']);

    $search = $declarations->first()->last_name;

    livewire(ListDeclarations::class)
        ->loadTable()
        ->searchTable($search)
        ->assertCanSeeTableRecords($declarations->where('last_name', $search))
        ->assertCanNotSeeTableRecords($declarations->where('last_name', '!=', $search));
});

it('can create a declaration', function () {
    $budgetArticle = BudgetArticle::factory()->create();
    $declaration = Declaration::factory()->make(['user_add' => 'aaguirre']);

    livewire(CreateDeclaration::class)
        ->fillForm([
            'last_name' => $declaration->last_name,
            'first_name' => $declaration->first_name,
            'street' => $declaration->street,
            'postal_code' => $declaration->postal_code,
            'city' => $declaration->city,
            'iban' => $declaration->iban,
            'car_license_plate1' => $declaration->car_license_plate1,
            'rate' => $declaration->rate,
            'rate_omnium' => $declaration->rate_omnium,
            'type_movement' => $declaration->type_movement,
            'budget_article' => $budgetArticle->name,
        ])
        ->call('create')
        ->assertNotified();

    assertDatabaseHas(Declaration::class, [
        'last_name' => $declaration->last_name,
        'first_name' => $declaration->first_name,
        'iban' => $declaration->iban,
    ]);
});

it('can update a declaration', function () {
    $declaration = Declaration::factory()->create(['user_add' => 'aaguirre']);
    $newData = Declaration::factory()->make(['user_add' => 'aaguirre']);

    livewire(EditDeclaration::class, ['record' => $declaration->id])
        ->fillForm([
            'last_name' => $newData->last_name,
            'first_name' => $newData->first_name,
            'street' => $newData->street,
            'postal_code' => $newData->postal_code,
            'city' => $newData->city,
            'iban' => $newData->iban,
            'car_license_plate1' => $newData->car_license_plate1,
            'rate' => $newData->rate,
            'rate_omnium' => $newData->rate_omnium,
        ])
        ->call('save')
        ->assertNotified();

    assertDatabaseHas(Declaration::class, [
        'id' => $declaration->id,
        'last_name' => $newData->last_name,
        'first_name' => $newData->first_name,
        'iban' => $newData->iban,
    ]);
});

it('can delete a declaration', function () {
    $declaration = Declaration::factory()->create(['user_add' => 'aaguirre']);

    livewire(EditDeclaration::class, ['record' => $declaration->id])
        ->callAction(DeleteAction::class)
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseMissing($declaration);
});

it('validates the form data', function (array $data, array $errors) {
    $declaration = Declaration::factory()->create(['user_add' => 'aaguirre']);
    $newData = Declaration::factory()->make(['user_add' => 'aaguirre']);

    livewire(EditDeclaration::class, ['record' => $declaration->id])
        ->fillForm([
            'last_name' => $newData->last_name,
            'first_name' => $newData->first_name,
            'street' => $newData->street,
            'postal_code' => $newData->postal_code,
            'city' => $newData->city,
            'iban' => $newData->iban,
            'car_license_plate1' => $newData->car_license_plate1,
            'rate' => $newData->rate,
            'rate_omnium' => $newData->rate_omnium,
            ...$data,
        ])
        ->call('save')
        ->assertHasFormErrors($errors)
        ->assertNotNotified();
})->with([
    '`last_name` is required' => [['last_name' => null], ['last_name' => 'required']],
    '`iban` is required' => [['iban' => null], ['iban' => 'required']],
    '`car_license_plate1` is required' => [['car_license_plate1' => null], ['car_license_plate1' => 'required']],
]);
