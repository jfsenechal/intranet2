<?php

declare(strict_types=1);

namespace AcMarche\App\Filament\Pages;

use AcMarche\Hrm\Filament\Resources\Teleworks\Schemas\TeleworkForm;
use AcMarche\Hrm\Models\Telework as TeleworkModel;
use AcMarche\Hrm\Services\TeleworkNotifier;
use BackedEnum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
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
