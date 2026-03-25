<?php

declare(strict_types=1);

use AcMarche\MailingList\Filament\Resources\Contacts\Pages\CreateContact;
use AcMarche\MailingList\Filament\Resources\Contacts\Pages\EditContact;
use AcMarche\MailingList\Filament\Resources\Contacts\Pages\ListContacts;
use AcMarche\MailingList\Models\Contact;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Str;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can render the index page', function () {
    livewire(ListContacts::class)
        ->assertOk();
});

it('can render the create page', function () {
    livewire(CreateContact::class)
        ->assertOk();
});

it('can render the edit page', function () {
    $contact = Contact::factory()->create(['username' => $this->user->username]);

    livewire(EditContact::class, ['record' => $contact->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'last_name' => $contact->last_name,
            'first_name' => $contact->first_name,
            'email' => $contact->email,
        ]);
});

it('can list contacts', function () {
    $contacts = Contact::factory(3)->create(['username' => $this->user->username]);

    livewire(ListContacts::class)
        ->loadTable()
        ->assertCanSeeTableRecords($contacts);
});

it('has table columns', function (string $column) {
    livewire(ListContacts::class)
        ->assertTableColumnExists($column);
})->with(['last_name', 'first_name', 'email', 'phone', 'created_at', 'updated_at']);

it('can sort column', function (string $column) {
    $contacts = Contact::factory(5)->create(['username' => $this->user->username]);

    livewire(ListContacts::class)
        ->loadTable()
        ->sortTable($column)
        ->assertCanSeeTableRecords($contacts->sortBy($column), inOrder: true)
        ->sortTable($column, 'desc')
        ->assertCanSeeTableRecords($contacts->sortByDesc($column), inOrder: true);
})->with(['last_name', 'first_name', 'email']);

it('can search contacts', function () {
    $contacts = Contact::factory(5)->create(['username' => $this->user->username]);

    $search = $contacts->first()->last_name;

    livewire(ListContacts::class)
        ->loadTable()
        ->searchTable($search)
        ->assertCanSeeTableRecords($contacts->where('last_name', $search))
        ->assertCanNotSeeTableRecords($contacts->where('last_name', '!=', $search));
});

it('can create a contact', function () {
    $contact = Contact::factory()->make();

    livewire(CreateContact::class)
        ->fillForm([
            'last_name' => $contact->last_name,
            'first_name' => $contact->first_name,
            'email' => $contact->email,
            'phone' => $contact->phone,
        ])
        ->call('create')
        ->assertNotified();

    assertDatabaseHas(Contact::class, [
        'last_name' => $contact->last_name,
        'first_name' => $contact->first_name,
        'email' => $contact->email,
        'username' => $this->user->username,
    ]);
});

it('can update a contact', function () {
    $contact = Contact::factory()->create(['username' => $this->user->username]);
    $newData = Contact::factory()->make();

    livewire(EditContact::class, ['record' => $contact->id])
        ->fillForm([
            'last_name' => $newData->last_name,
            'first_name' => $newData->first_name,
            'email' => $newData->email,
        ])
        ->call('save')
        ->assertNotified();

    assertDatabaseHas(Contact::class, [
        'id' => $contact->id,
        'last_name' => $newData->last_name,
        'first_name' => $newData->first_name,
        'email' => $newData->email,
    ]);
});

it('can delete a contact', function () {
    $contact = Contact::factory()->create(['username' => $this->user->username]);

    livewire(EditContact::class, ['record' => $contact->id])
        ->callAction(DeleteAction::class)
        ->assertNotified()
        ->assertRedirect();

    assertDatabaseMissing($contact);
});

it('can bulk delete contacts', function () {
    $contacts = Contact::factory(3)->create(['username' => $this->user->username]);

    livewire(ListContacts::class)
        ->loadTable()
        ->assertCanSeeTableRecords($contacts)
        ->selectTableRecords($contacts)
        ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
        ->assertNotified()
        ->assertCanNotSeeTableRecords($contacts);

    $contacts->each(fn (Contact $contact) => assertDatabaseMissing($contact));
});

it('validates unique email', function () {
    $existing = Contact::factory()->create(['username' => $this->user->username]);

    livewire(CreateContact::class)
        ->fillForm([
            'last_name' => 'Test',
            'first_name' => 'Test',
            'email' => $existing->email,
        ])
        ->call('create')
        ->assertHasFormErrors(['email' => 'unique']);
});

it('validates the form data', function (array $data, array $errors) {
    $contact = Contact::factory()->create(['username' => $this->user->username]);
    $newData = Contact::factory()->make();

    livewire(EditContact::class, ['record' => $contact->id])
        ->fillForm([
            'last_name' => $newData->last_name,
            'first_name' => $newData->first_name,
            'email' => $newData->email,
            ...$data,
        ])
        ->call('save')
        ->assertHasFormErrors($errors)
        ->assertNotNotified();
})->with([
    '`last_name` is required' => [['last_name' => null], ['last_name' => 'required']],
    '`last_name` is max 255 characters' => [['last_name' => Str::random(256)], ['last_name' => 'max']],
    '`first_name` is required' => [['first_name' => null], ['first_name' => 'required']],
    '`first_name` is max 255 characters' => [['first_name' => Str::random(256)], ['first_name' => 'max']],
    '`email` is required' => [['email' => null], ['email' => 'required']],
    '`email` is a valid email address' => [['email' => Str::random()], ['email' => 'email']],
    '`email` is max 255 characters' => [['email' => Str::random(256)], ['email' => 'max']],
]);
