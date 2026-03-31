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
        $path = $this->modulePath();
        $name = $this->moduleName();

        $this->loadMigrationsFrom($path.'/database/migrations');
        RegisterPolicies::register();

        // Load views
        $this->loadViewsFrom($path.'/resources/views', 'pst-view');

        // Load routes
        if (file_exists($path.'/routes/web.php')) {
            $this->loadRoutesFrom($path.'/routes/web.php');
        }

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                MeiliCommand::class,
                FixCommand::class,
            ]);
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
            $path.'/resources/views' => resource_path('views/vendor/pst'),
        ], "{$name}-views");

        // Publish assets
        $this->publishes([
            $path.'/resources/assets' => public_path("vendor/{$name}"),
        ], "{$name}-assets");

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

    protected function modulePath(): string
    {
        return __DIR__.'/../..';
    }
}
