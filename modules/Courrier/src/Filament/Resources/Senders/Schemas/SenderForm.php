<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Filament\Resources\Senders\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

final class SenderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('Nom')
                    ->required(),
            ]);
    }
}
