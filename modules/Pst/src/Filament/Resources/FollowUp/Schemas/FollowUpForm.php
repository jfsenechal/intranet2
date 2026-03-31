<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\FollowUp\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

final class FollowUpForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('content')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('icon')
                    ->label('Icône')
                    ->disk('public')
                    ->directory(config('pst.uploads.followups_icons')),
            ]);
    }
}
