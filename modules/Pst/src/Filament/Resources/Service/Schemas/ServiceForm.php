<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\Service\Schemas;

use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;

final class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('initials')
                    ->maxLength(30),
                Forms\Components\Select::make('users')
                    ->label('Agents membres')
                    ->relationship('users', 'last_name')
                    ->searchable(['first_name', 'last_name'])
                    ->getOptionLabelFromRecordUsing(fn (User $user): string => $user->first_name.' '.$user->last_name)
                    ->multiple()
                    ->columnSpanFull(),
            ]);
    }
}
