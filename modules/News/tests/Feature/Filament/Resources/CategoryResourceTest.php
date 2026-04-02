<?php

declare(strict_types=1);

use AcMarche\News\Filament\Resources\Categories\Pages\CreateCategory;
use AcMarche\News\Filament\Resources\Categories\Pages\EditCategory;
use AcMarche\News\Filament\Resources\Categories\Pages\ListCategory;
use AcMarche\News\Filament\Resources\Categories\Pages\ViewCategory;
use AcMarche\News\Filament\Resources\Categories\RelationManagers\NewsRelationManager;
use AcMarche\News\Models\Category;
use AcMarche\News\Models\News;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

beforeEach(function () {
    Mail::fake();
    Filament::setCurrentPanel(Filament::getPanel('news'));
    auth()->user()->update(['is_administrator' => true]);

    // Register dummy routes to prevent URL generation errors in tests
    if (! Route::getRoutes()->getByName('filament.news.resources.categories.index')) {
        Route::get('/categories', fn () => '')->name('filament.news.resources.categories.index');
        Route::get('/categories/create', fn () => '')->name('filament.news.resources.categories.create');
        Route::get('/categories/{record}/edit', fn () => '')->name('filament.news.resources.categories.edit');
        Route::get('/categories/{record}', fn () => '')->name('filament.news.resources.categories.view');
    }
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

    livewire(EditCategory::class, [
        'record' => $category->id,
    ])
        ->assertOk()
        ->assertSchemaStateSet([
            'name' => $category->name,
        ]);
});

it('can render the view page', function () {
    $category = Category::factory()->create();

    livewire(ViewCategory::class, [
        'record' => $category->id,
    ])
        ->assertOk();
});

it('has column', function (string $column) {
    livewire(ListCategory::class)
        ->assertTableColumnExists($column);
})->with(['name', 'color', 'news_count']);

it('can render column', function (string $column) {
    livewire(ListCategory::class)
        ->assertCanRenderTableColumn($column);
})->with(['name', 'color']);

it('can load the create form', function () {
    livewire(CreateCategory::class)
        ->assertSchemaComponentExists('name');
});

it('can load the edit form with data', function () {
    $category = Category::factory()->create();

    livewire(EditCategory::class, [
        'record' => $category->id,
    ])
        ->assertSchemaStateSet([
            'name' => $category->name,
        ]);
});

it('can delete a category', function () {
    $category = Category::factory()->create();

    livewire(ViewCategory::class, [
        'record' => $category->id,
    ])
        ->callAction(DeleteAction::class)
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseMissing(Category::class, ['id' => $category->id]);
});

it('can bulk delete categories', function () {
    $categories = Category::factory(5)->create();

    livewire(ListCategory::class)
        ->loadTable()
        ->assertCanSeeTableRecords($categories)
        ->selectTableRecords($categories)
        ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
        ->assertNotified()
        ->assertCanNotSeeTableRecords($categories);

    $categories->each(fn (Category $category) => assertDatabaseMissing(Category::class, ['id' => $category->id]));
});

it('can search categories by name', function () {
    $category1 = Category::factory()->create(['name' => 'Development']);
    $category2 = Category::factory()->create(['name' => 'Design']);

    livewire(ListCategory::class)
        ->loadTable()
        ->searchTable('Development')
        ->assertCanSeeTableRecords([$category1])
        ->assertCanNotSeeTableRecords([$category2]);
});

it('displays table actions on list page', function () {
    $category = Category::factory()->create();

    livewire(ListCategory::class)
        ->loadTable()
        ->assertCanSeeTableRecords([$category])
        ->assertTableActionExists('view')
        ->assertTableActionExists('edit');
});

it('displays delete action on view page', function () {
    $category = Category::factory()->create();

    livewire(ViewCategory::class, [
        'record' => $category->id,
    ])
        ->assertActionExists('delete');
});

it('displays news count on list page', function () {
    $category = Category::factory()->create();
    News::factory(3)->create(['category_id' => $category->id]);

    livewire(ListCategory::class)
        ->loadTable()
        ->assertCanSeeTableRecords([$category])
        ->assertTableColumnStateSet('news_count', 3, $category);
});

it('can render the news relation manager on view page', function () {
    $category = Category::factory()->create();

    livewire(NewsRelationManager::class, [
        'ownerRecord' => $category,
        'pageClass' => ViewCategory::class,
    ])
        ->assertOk();
});

it('lists related news in the relation manager', function () {
    $category = Category::factory()->create();
    $news = News::factory(2)->create(['category_id' => $category->id]);
    $otherNews = News::factory()->create();

    livewire(NewsRelationManager::class, [
        'ownerRecord' => $category,
        'pageClass' => ViewCategory::class,
    ])
        ->loadTable()
        ->assertCanSeeTableRecords($news)
        ->assertCanNotSeeTableRecords([$otherNews]);
});

it('denies create action for regular user', function () {
    auth()->user()->update(['is_administrator' => false]);

    livewire(ListCategory::class)
        ->assertActionHidden('create');
});

it('denies edit action for regular user', function () {
    auth()->user()->update(['is_administrator' => false]);
    $category = Category::factory()->create();

    livewire(ListCategory::class)
        ->loadTable()
        ->assertTableActionHidden('edit', $category);
});
