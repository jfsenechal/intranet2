<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Diplomas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class DiplomaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Diplôme')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Intitulé'),
                        TextEntry::make('certificate_file')
                            ->label('Fichier attestation')
                            ->placeholder('—'),
                        TextEntry::make('user_add')
                            ->label('Ajouté par'),
                        TextEntry::make('created_at')
                            ->label('Créé le')
                            ->date('d/m/Y'),
                        TextEntry::make('updated_by')
                            ->label('Modifié par')
                            ->placeholder('—'),
                        TextEntry::make('updated_at')
                            ->label('Modifié le')
                            ->date('d/m/Y'),
                    ]),
            ]);
    }
}
