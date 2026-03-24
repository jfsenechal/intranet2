<?php

namespace AcMarche\Pst\Filament\Widgets;

use AcMarche\Pst\Filament\Resources\ActionPst\Tables\ActionTables;
use AcMarche\Pst\Repository\ActionRepository;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

final class ActionsTableWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function table(Table $table): Table
    {
        $user = auth()->user();
        $table
            ->heading('Actions vous concernant')
            ->description('Vous êtes repris comme agent pilote')
            ->query(
                ActionRepository::findByUser($user->id)
            );

        return ActionTables::actionsForWidget($table, limit: 60);
    }
}
