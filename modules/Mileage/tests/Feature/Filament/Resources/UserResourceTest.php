<?php

declare(strict_types=1);

use AcMarche\Mileage\Enums\RolesEnum;
use AcMarche\Mileage\Filament\Resources\Users\Pages\CreateUser;
use AcMarche\Mileage\Filament\Resources\Users\Pages\ListUsers;
use AcMarche\Mileage\Models\PersonalInformation;
use AcMarche\Security\Models\Role;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

use function Pest\Livewire\livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('mileage-panel'));

    // Register dummy routes to prevent URL generation errors in tests
    if (! Route::getRoutes()->getByName('filament.mileage-panel.resources.users.index')) {
        Route::get('/users', fn () => '')->name('filament.mileage-panel.resources.users.index');
        Route::get('/users/create', fn () => '')->name('filament.mileage-panel.resources.users.create');
        Route::get('/users/{record}/edit', fn () => '')->name('filament.mileage-panel.resources.users.edit');
    }

    $this->user = User::factory()->create(['is_administrator' => true]);
    $role = Role::factory()->create(['name' => RolesEnum::ROLE_FINANCE_DEPLACEMENT_ADMIN->value]);
    $this->user->roles()->attach($role);
    PersonalInformation::factory()->create(['username' => $this->user->username]);
    $this->actingAs($this->user);
});

it('can render the users index page', function () {
    livewire(ListUsers::class)
        ->assertOk();
});

it('can render the create user page', function () {
    livewire(CreateUser::class)
        ->assertOk();
});

it('can load the table', function () {
    livewire(ListUsers::class)
        ->loadTable()
        ->assertOk();
});

it('has table columns', function (string $column) {
    livewire(ListUsers::class)
        ->assertTableColumnExists($column);
})->with(['email', 'last_name', 'first_name', 'department']);

it('can load the create form with components', function () {
    livewire(CreateUser::class)
        ->assertSchemaComponentExists('username')
        ->assertSchemaComponentExists('college_trip_date')
        ->assertSchemaComponentExists('omnium');
});

it('displays edit action on list page', function () {
    livewire(ListUsers::class)
        ->assertTableActionExists('edit');
});
