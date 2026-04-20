<?php

declare(strict_types=1);

namespace AcMarche\App\Filament\Resources\Signatures\Schemas;

use App\Enums\SignatureEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class SignatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Identité')
                    ->columns(2)
                    ->schema([
                        TextInput::make('prenom')
                            ->label('Prénom')
                            ->required(),
                        TextInput::make('nom')
                            ->label('Nom')
                            ->required(),
                        TextInput::make('fonction')
                            ->label('Fonction'),
                        TextInput::make('service')
                            ->label('Service'),
                    ]),
                Section::make('Adresse')
                    ->columns(4)
                    ->schema([
                        TextInput::make('adresse')
                            ->label('Adresse')
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('code_postal')
                            ->label('Code postal')
                            ->required()
                            ->numeric(),
                        TextInput::make('localite')
                            ->label('Localité')
                            ->required(),
                    ]),
                Section::make('Contact')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        TextInput::make('website')
                            ->label('Site web')
                            ->url(),
                        TextInput::make('telephone')
                            ->label('Téléphone')
                            ->tel(),
                        TextInput::make('gsm')
                            ->label('GSM')
                            ->tel(),
                    ]),
                Section::make('Logo')
                    ->columns(2)
                    ->schema([
                        Select::make('logo')
                            ->label('Logo')
                            ->options(
                                collect(SignatureEnum::cases())
                                    ->mapWithKeys(fn (SignatureEnum $enum): array => [$enum->value => $enum->getTitle()])
                                    ->all()
                            )
                            ->searchable(),
                        TextInput::make('logotitle')
                            ->label('Titre du logo'),
                    ]),
            ]);
    }
}
