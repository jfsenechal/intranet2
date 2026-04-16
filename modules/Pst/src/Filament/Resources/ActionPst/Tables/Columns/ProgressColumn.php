<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Resources\ActionPst\Tables\Columns;

use Filament\Tables\Columns\Column;

/**
 * https://laraveldaily.com/post/filament-custom-table-column-progress-bar
 */
final class ProgressColumn extends Column
{
    #[\Override]
    protected string $view = 'tables.columns.progress-column';
}
