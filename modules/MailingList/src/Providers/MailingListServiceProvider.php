<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Providers;

use AcMarche\App\Traits\ModuleServiceProviderTrait;
use AcMarche\Pst\Policies\RegisterPolicies;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

final class MailingListServiceProvider extends ServiceProvider
{
    use ModuleServiceProviderTrait;

    public function register(): void
    {
        $this->registerModuleConfig();
    }

    public function boot(): void
    {
        RegisterPolicies::register();
        $this->bootModule();

        FilamentView::registerRenderHook(
            PanelsRenderHook::TOPBAR_START,
            function (): View {
                return view('mailing-list-view::filament.topbar');
            },
            scopes: 'mailing-list',
        );
    }

    protected function moduleName(): string
    {
        return 'mailing-list';
    }

}
