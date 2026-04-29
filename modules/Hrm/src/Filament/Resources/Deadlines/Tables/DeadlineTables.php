<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Filament\Resources\Deadlines\Tables;

use AcMarche\Hrm\Filament\Resources\Deadlines\DeadlineResource;
use AcMarche\Hrm\Models\Deadline;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class DeadlineTables
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'desc')
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('name')
                    ->label('Intitulé')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employee.last_name')
                    ->label('Agent')
                    ->formatStateUsing(
                        fn (Deadline $record): string => $record->employee?->last_name.' '.$record->employee?->first_name
                    )
                    ->searchable(['last_name', 'first_name'])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('employer.name')
                    ->label('Employeur')
                    ->sortable()
                    ->toggleable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('start_date')
                    ->label('Début')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('reminder_date')
                    ->label('Rappel')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('closed_date')
                    ->label('Clôture')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_closed')
                    ->label('Clôturée')
                    ->boolean()
                    ->toggleable(),
            ])
            ->filtersFormColumns(2)
            ->persistFiltersInSession()
            ->filters([
                SelectFilter::make('employer_id')
                    ->label('Employeur')
                    ->relationship('employer', 'name'),
                SelectFilter::make('service_id')
                    ->label('Service')
                    ->relationship('service', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('direction_id')
                    ->label('Direction')
                    ->relationship('direction', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('end_date_from')
                    ->label("Date de l'échéance")
                    ->schema([
                        DatePicker::make('end_date_from')
                            ->label('À partir de'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['end_date_from'] ?? null,
                        fn (Builder $query, $date): Builder => $query->whereDate('end_date', '>=', $date),
                    )),
                Filter::make('reminder_date_from')
                    ->label('Date de rappel')
                    ->schema([
                        DatePicker::make('reminder_date_from')
                            ->label('À partir de'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['reminder_date_from'] ?? null,
                        fn (Builder $query, $date): Builder => $query->whereDate('reminder_date', '>=', $date),
                    )),
                TernaryFilter::make('is_closed')
                    ->label('Clôture')
                    ->placeholder('Toutes')
                    ->trueLabel('Clôturées')
                    ->falseLabel('En cours')
                    ->default(false),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->recordAction(ViewAction::class)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function relation(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'desc')
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('name')
                    ->label('Intitulé')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employer.name')
                    ->label('Employeur')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->label('Debut')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('reminder_date')
                    ->label('Rappel')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_closed')
                    ->label('Clôturée')
                    ->boolean(),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('Voir')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Deadline $record): string => DeadlineResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
