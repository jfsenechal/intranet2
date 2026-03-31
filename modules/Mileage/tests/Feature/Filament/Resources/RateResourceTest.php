<?php

declare(strict_types=1);

use AcMarche\Mileage\Enums\RolesEnum;
use AcMarche\Mileage\Filament\Resources\Rates\Pages\CreateRate;
use AcMarche\Mileage\Filament\Resources\Rates\Pages\EditRate;
use AcMarche\Mileage\Filament\Resources\Rates\Pages\ListRates;
use AcMarche\Mileage\Models\PersonalInformation;
use AcMarche\Mileage\Models\Rate;
use AcMarche\Security\Models\Role;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('mileage-panel'));
    $this->user = User::factory()->create(['is_administrator' => true]);
    $role = Role::factory()->create(['name' => RolesEnum::ROLE_FINANCE_DEPLACEMENT_ADMIN->value]);
    $this->user->roles()->attach($role);
    PersonalInformation::factory()->create(['username' => $this->user->username]);
    $this->actingAs($this->user);
});

it('can render the index page', function () {
    livewire(ListRates::class)
        ->assertOk();
});

it('can render the create page', function () {
    livewire(CreateRate::class)
        ->assertOk();
});

it('can render the edit page', function () {
    $rate = Rate::factory()->create();

    livewire(EditRate::class, ['record' => $rate->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'amount' => $rate->amount,
            'omnium' => $rate->omnium,
            'start_date' => $rate->start_date,
            'end_date' => $rate->end_date,
        ]);
});

it('can list rates', function () {
    $rates = Rate::factory(3)->create();

    livewire(ListRates::class)
        ->loadTable()
        ->assertCanSeeTableRecords($rates);
});

it('has table columns', function (string $column) {
    livewire(ListRates::class)
        ->assertTableColumnExists($column);
})->with(['start_date', 'end_date', 'amount', 'omnium']);

it('can sort column', function (string $column) {
    $rates = Rate::factory(5)->create();

    livewire(ListRates::class)
        ->loadTable()
        ->sortTable($column)
        ->assertCanSeeTableRecords($rates->sortBy($column), inOrder: true)
        ->sortTable($column, 'desc')
        ->assertCanSeeTableRecords($rates->sortByDesc($column), inOrder: true);
})->with(['start_date', 'amount']);

it('can create a rate', function () {
    $rate = Rate::factory()->make();

    livewire(CreateRate::class)
        ->fillForm([
            'amount' => $rate->amount,
            'omnium' => $rate->omnium,
            'start_date' => $rate->start_date,
            'end_date' => $rate->end_date,
        ])
        ->call('create')
        ->assertNotified();

    assertDatabaseHas(Rate::class, [
        'amount' => $rate->amount,
        'omnium' => $rate->omnium,
    ]);
});

it('can update a rate', function () {
    $rate = Rate::factory()->create();
    $newData = Rate::factory()->make();

    livewire(EditRate::class, ['record' => $rate->id])
        ->fillForm([
            'amount' => $newData->amount,
            'omnium' => $newData->omnium,
            'start_date' => $newData->start_date,
            'end_date' => $newData->end_date,
        ])
        ->call('save')
        ->assertNotified();

    assertDatabaseHas(Rate::class, [
        'id' => $rate->id,
        'amount' => $newData->amount,
        'omnium' => $newData->omnium,
    ]);
});

it('can delete a rate', function () {
    $rate = Rate::factory()->create();

    livewire(EditRate::class, ['record' => $rate->id])
        ->callAction(DeleteAction::class)
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseMissing($rate);
});

it('validates the form data', function (array $data, array $errors) {
    $rate = Rate::factory()->create();
    $newData = Rate::factory()->make();

    livewire(EditRate::class, ['record' => $rate->id])
        ->fillForm([
            'amount' => $newData->amount,
            'omnium' => $newData->omnium,
            'start_date' => $newData->start_date,
            'end_date' => $newData->end_date,
            ...$data,
        ])
        ->call('save')
        ->assertHasFormErrors($errors)
        ->assertNotNotified();
})->with([
    '`amount` is required' => [['amount' => null], ['amount' => 'required']],
    '`omnium` is required' => [['omnium' => null], ['omnium' => 'required']],
    '`start_date` is required' => [['start_date' => null], ['start_date' => 'required']],
    '`end_date` is required' => [['end_date' => null], ['end_date' => 'required']],
]);
