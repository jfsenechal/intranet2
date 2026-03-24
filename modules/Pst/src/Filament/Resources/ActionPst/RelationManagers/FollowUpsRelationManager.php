<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\ActionPst\RelationManagers;

use AcMarche\Pst\Filament\Resources\FollowUp\Tables\FollowUpTables;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

final class FollowUpsRelationManager extends RelationManager
{
    protected static string $relationship = 'followups';

    protected static ?string $title = 'Suivi';

    protected static ?string $label = 'Suivi';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\RichEditor::make('content')
                    ->label('Contenu')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return FollowUpTables::configure($table);
    }
}
