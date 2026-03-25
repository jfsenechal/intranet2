<?php

declare(strict_types=1);

namespace AcMarche\Pst\Providers;

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
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/pst.php',
            'pst'
        );

        // Register database connection from module config
        $this->registerDatabaseConnection();
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        RegisterPolicies::register();

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'pst-view');

        // Load routes
        if (file_exists(__DIR__.'/../../routes/web.php')) {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
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
            __DIR__.'/../../config/pst.php' => config_path('pst.php'),
        ], 'pst-config');

        // Publish database config
        $this->publishes([
            __DIR__.'/../../config/database.php' => config_path('pst-database.php'),
        ], 'pst-database-config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'pst-migrations');

        // Publish views
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/pst'),
        ], 'pst-views');

        // Publish assets
        $this->publishes([
            __DIR__.'/../../resources/assets' => public_path('vendor/pst'),
        ], 'pst-assets');

        FilamentView::registerRenderHook(
            PanelsRenderHook::TOPBAR_START,
            function (): View {
                return view('pst-view::filament.topbar', ['department' => UserRepository::departmentSelected()]);
            },
            scopes: 'pst',
        );
    }

    /**
     * Register the module's database connection.
     */
    protected function registerDatabaseConnection(): void
    {
        $connections = require __DIR__.'/../../config/database.php';

        foreach ($connections['connections'] ?? [] as $name => $config) {
            config(['database.connections.'.$name => $config]);
        }
    }
}
