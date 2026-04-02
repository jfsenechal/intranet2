<?php

declare(strict_types=1);

use AcMarche\Document\Filament\Resources\Categories\Pages\CreateCategory;
use AcMarche\Document\Filament\Resources\Categories\Pages\EditCategory;
use AcMarche\Document\Filament\Resources\Categories\Pages\ListCategory;
use AcMarche\Document\Filament\Resources\Categories\Pages\ViewCategory;
use AcMarche\Document\Models\Category;
use AcMarche\Security\Models\Role;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('document-panel'));
    $this->user = User::factory()->create();
    $role = Role::factory()->create(['name' => 'ROLE_DOCUMENT_ADMIN']);
    $this->user->roles()->attach($role);
    $this->actingAs($this->user);
});

it('can render the index page', function () {
    livewire(ListCategory::class)
        ->assertOk();
});

it('can render the create page', function () {
    livewire(CreateCategory::class)
        ->assertOk();
});

it('can render the edit page', function () {
    $category = Category::factory()->create();

    livewire(EditCategory::class, ['record' => $category->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'name' => $category->name,
        ]);
});

it('can render the view page', function () {
    $category = Category::factory()->create();

    livewire(ViewCategory::class, ['record' => $category->id])
        ->assertOk();
});

it('can list categories', function () {
    $categories = Category::factory(3)->create();

    livewire(ListCategory::class)
        ->loadTable()
        ->assertCanSeeTableRecords($categories);
});

it('has table columns', function (string $column) {
    livewire(ListCategory::class)
        ->assertTableColumnExists($column);
})->with(['name']);

it('can sort by name', function () {
    $categories = Category::factory(5)->create();

    livewire(ListCategory::class)
        ->loadTable()
        ->sortTable('name')
        ->assertCanSeeTableRecords($categories)
        ->sortTable('name', 'desc')
        ->assertCanSeeTableRecords($categories);
});

it('can search categories', function () {
    $categories = Category::factory(5)->create();

    $search = $categories->first()->name;

    livewire(ListCategory::class)
        ->loadTable()
        ->searchTable($search)
        ->assertCanSeeTableRecords($categories->where('name', $search))
        ->assertCanNotSeeTableRecords($categories->where('name', '!=', $search));
});

it('can create a category', function () {
    $category = Category::factory()->make();

    livewire(CreateCategory::class)
        ->fillForm([
            'name' => $category->name,
        ])
        ->call('create')
        ->assertNotified();

    assertDatabaseHas(Category::class, [
        'name' => $category->name,
    ]);
});

it('can update a category', function () {
    $category = Category::factory()->create();
    $newData = Category::factory()->make();

    livewire(EditCategory::class, ['record' => $category->id])
        ->fillForm([
            'name' => $newData->name,
        ])
        ->call('save')
        ->assertNotified();

    assertDatabaseHas(Category::class, [
        'id' => $category->id,
        'name' => $newData->name,
    ]);
});

it('can delete a category from view page', function () {
    $category = Category::factory()->create();

    livewire(ViewCategory::class, ['record' => $category->id])
        ->callAction(DeleteAction::class)
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseMissing($category);
});

it('can bulk delete categories', function () {
    $categories = Category::factory(3)->create();

    livewire(ListCategory::class)
        ->loadTable()
        ->assertCanSeeTableRecords($categories)
        ->selectTableRecords($categories)
        ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
        ->assertNotified()
        ->assertCanNotSeeTableRecords($categories);

    $categories->each(fn (Category $category) => assertDatabaseMissing($category));
});

it('validates the form data', function (array $data, array $errors) {
    $category = Category::factory()->create();

    livewire(EditCategory::class, ['record' => $category->id])
        ->fillForm([
            'name' => 'Valid Name',
            ...$data,
        ])
        ->call('save')
        ->assertHasFormErrors($errors)
        ->assertNotNotified();
})->with([
    '`name` is required' => [['name' => null], ['name' => 'required']],
]);

it('prevents a regular user from creating a category', function () {
    $regularUser = User::factory()->create();
    $this->actingAs($regularUser);

    livewire(CreateCategory::class)
        ->assertForbidden();
});

it('prevents a regular user from editing a category', function () {
    $regularUser = User::factory()->create();
    $this->actingAs($regularUser);
    $category = Category::factory()->create();

    livewire(EditCategory::class, ['record' => $category->id])
        ->assertForbidden();
});

it('prevents a regular user from deleting a category', function () {
    $regularUser = User::factory()->create();
    $this->actingAs($regularUser);
    $category = Category::factory()->create();

    livewire(ViewCategory::class, ['record' => $category->id])
        ->assertActionHidden(DeleteAction::class);
});
