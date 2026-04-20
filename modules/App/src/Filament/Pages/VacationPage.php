<?php

declare(strict_types=1);

namespace AcMarche\App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Override;

final class VacationPage extends Page
{
    #[Override]
    protected static string|null|BackedEnum $navigationIcon = Heroicon::PaperAirplane;

    #[Override]
    protected static ?string $navigationLabel = 'Absence de bureau';

    #[Override]
    protected string $view = 'app::filament.pages.vacation';

    public function getTitle(): string
    {
        return 'Absence de bureau';
    }
}
