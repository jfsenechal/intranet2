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

        $path = $this->modulePath();
        $name = $this->moduleName();

        // Load migrations
        $this->loadMigrationsFrom($path.'/database/migrations');

        // Load views (note: views are in views/ not resources/views/)
        $this->loadViewsFrom($path.'/views', 'mailing-list-view');

        // Load routes
        if (file_exists($path.'/routes/web.php')) {
            $this->loadRoutesFrom($path.'/routes/web.php');
        }

        // Publish config
        $this->publishes([
            $path."/config/{$name}.php" => config_path("{$name}.php"),
        ], "{$name}-config");

        // Publish database config
        $this->publishes([
            $path.'/config/database.php' => config_path("{$name}-database.php"),
        ], "{$name}-database-config");

        // Publish migrations
        $this->publishes([
            $path.'/database/migrations' => database_path('migrations'),
        ], "{$name}-migrations");

        // Publish views
        $this->publishes([
            $path.'/views' => resource_path('views/vendor/mailing-list'),
        ], "{$name}-views");

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

    protected function modulePath(): string
    {
        return __DIR__.'/../..';
    }
}
