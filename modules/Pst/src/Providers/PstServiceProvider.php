<?php

declare(strict_types=1);

namespace AcMarche\Pst\Providers;

use AcMarche\App\Traits\ModuleServiceProviderTrait;
use AcMarche\Pst\Console\Commands\FixCommand;
use AcMarche\Pst\Console\Commands\MeiliCommand;
use AcMarche\Pst\Policies\RegisterPolicies;
use AcMarche\Security\Repository\UserRepository;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

final class PstServiceProvider extends ServiceProvider
{
    use ModuleServiceProviderTrait;

    public function register(): void
    {
        $this->registerModuleConfig();
    }

    public function boot(): void
    {
        RegisterPolicies::register();

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                MeiliCommand::class,
                FixCommand::class,
            ]);
        }

        FilamentView::registerRenderHook(
            PanelsRenderHook::TOPBAR_START,
            function (): View {
                return view('pst-view::filament.topbar', ['department' => UserRepository::departmentSelected()]);
            },
            scopes: 'pst',
        );
    }

    protected function moduleName(): string
    {
        return 'pst';
    }
}
