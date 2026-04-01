<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Widgets;

use AcMarche\Pst\Filament\Resources\ActionPst\Tables\ActionTables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

final class ActionsByServicesTableWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        $table
            ->heading('Actions de vos services')
            ->description('Actions où vous êtes membre d\'un service porteur ou partenaire')
            ->query(
                auth()->user()->actionsFromServices()
            );

        return ActionTables::actionsForWidget($table, limit: 60);
    }
}
