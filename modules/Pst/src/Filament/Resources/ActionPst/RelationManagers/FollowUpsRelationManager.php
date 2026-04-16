<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\ActionPst\RelationManagers;

use Override;
use Filament\Forms\Components\RichEditor;
use AcMarche\Pst\Filament\Resources\FollowUp\Tables\FollowUpTables;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

final class FollowUpsRelationManager extends RelationManager
{
    #[Override]
    protected static string $relationship = 'followups';

    #[Override]
    protected static ?string $title = 'Suivi';

    #[Override]
    protected static ?string $label = 'Suivi';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                RichEditor::make('content')
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
