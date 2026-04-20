<?php

declare(strict_types=1);

namespace AcMarche\App\Filament\Resources\Signatures\Schemas;

use AcMarche\App\Models\Signature;
use AcMarche\App\Services\SignatureHtmlGenerator;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class SignatureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Fieldset::make('Identité')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('prenom')->label('Prénom'),
                        TextEntry::make('nom')->label('Nom'),
                        TextEntry::make('fonction')->label('Fonction')->placeholder('—'),
                        TextEntry::make('service')->label('Service')->placeholder('—'),
                    ]),
                Fieldset::make('Adresse')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('adresse')->label('Adresse'),
                        TextEntry::make('code_postal')->label('Code postal'),
                        TextEntry::make('localite')->label('Localité'),
                    ]),
                Fieldset::make('Contact')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('telephone')->label('Téléphone')->placeholder('—'),
                        TextEntry::make('gsm')->label('GSM')->placeholder('—'),
                        TextEntry::make('website')->label('Site web')->placeholder('—'),
                    ]),
                Fieldset::make('Logo')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('logo')
                            ->label('Logo')
                            ->placeholder('—')
                            ->formatStateUsing(fn ($state) => $state?->getTitle() ?? '—'),
                        TextEntry::make('logotitle')->label('Titre du logo')->placeholder('—'),
                    ]),
                Section::make('Aperçu HTML')
                    ->schema([
                        TextEntry::make('preview')
                            ->hiddenLabel()
                            ->html()
                            ->state(fn (Signature $record): string => SignatureHtmlGenerator::generate($record)),
                    ]),
            ]);
    }
}
