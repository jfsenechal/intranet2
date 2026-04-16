<?php

declare(strict_types=1);

namespace AcMarche\Pst\Filament\Components;

use Override;
use Filament\Infolists\Components\Entry;

final class ProgressEntry extends Entry
{
    #[Override]
    protected string $view = 'components.progress-entry';
}
