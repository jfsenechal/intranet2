<?php

declare(strict_types=1);

namespace AcMarche\Document\Filament\Resources\Categories\RelationManagers;

use AcMarche\Document\Filament\Resources\Documents\DocumentResource;
use AcMarche\Document\Models\Document;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documents';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Intitulé')
                    ->searchable()
                    ->url(fn (Document $record) => DocumentResource::getUrl('view', ['record' => $record->id])),
            ])
            ->filters([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
