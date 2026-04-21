<?php

declare(strict_types=1);

namespace AcMarche\App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Override;

final class EmailsListPage extends Page
{
    #[Override]
    protected static string|null|BackedEnum $navigationIcon = Heroicon::AtSymbol;

    #[Override]
    protected static ?string $navigationLabel = 'Mails des services';

    #[Override]
    protected string $view = 'app::filament.pages.emails-list';

    public function getTitle(): string
    {
        return 'Adresses mails des services';
    }
}
