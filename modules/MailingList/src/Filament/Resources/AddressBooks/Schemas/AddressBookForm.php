<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Resources\AddressBooks\Schemas;

use AcMarche\MailingList\Models\AddressBook;
use AcMarche\MailingList\Models\AddressBookShare;
use AcMarche\MailingList\Models\Contact;
use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

final class AddressBookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->maxLength(255)
                    ->required(),
                Hidden::make('username')
                    ->default(fn (): ?string => auth()->user()?->username),
                Select::make('contacts')
                    ->relationship('contacts', 'email')
                    ->getOptionLabelFromRecordUsing(
                        fn (Contact $record): string => "{$record->first_name} {$record->last_name} ({$record->email})"
                    )
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        Grid::make(2)->schema([
                            TextInput::make('first_name')
                                ->maxLength(255)
                                ->required(),
                            TextInput::make('last_name')
                                ->maxLength(255)
                                ->required(),
                            TextInput::make('email')
                                ->email()
                                ->unique('contacts', 'email')
                                ->maxLength(255)
                                ->required(),
                            TextInput::make('phone')
                                ->tel()
                                ->maxLength(255),
                        ]),
                    ])
                    ->createOptionUsing(function (array $data): int {
                        return Contact::query()->create([
                            ...$data,
                            'username' => auth()->user()?->username,
                        ])->getKey();
                    }),
                Select::make('sharedWithUsers')
                    ->options(
                        fn (): array => User::query()
                            ->get()
                            ->mapWithKeys(fn (User $user): array => [
                                $user->username => "{$user->name} ({$user->email})",
                            ])
                            ->all()
                    )
                    ->multiple()
                    ->searchable()
                    ->afterStateHydrated(function (Select $component, ?AddressBook $record): void {
                        if ($record) {
                            $component->state(
                                AddressBookShare::query()
                                    ->where('address_book_id', $record->id)
                                    ->pluck('username')
                                    ->all()
                            );
                        }
                    })
                    ->saveRelationshipsUsing(function (AddressBook $record, ?array $state): void {
                        $usernames = collect($state ?? []);

                        AddressBookShare::query()
                            ->where('address_book_id', $record->id)
                            ->whereNotIn('username', $usernames)
                            ->delete();

                        $existing = AddressBookShare::query()
                            ->where('address_book_id', $record->id)
                            ->pluck('username');

                        $usernames->diff($existing)->each(fn (string $username) => AddressBookShare::query()->create([
                            'address_book_id' => $record->id,
                            'username' => $username,
                            'permission' => 'read',
                        ]));
                    })
                    ->dehydrated(false),
            ]);
    }
}
