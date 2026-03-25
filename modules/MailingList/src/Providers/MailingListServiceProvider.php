<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Providers;

use AcMarche\Pst\Policies\RegisterPolicies;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

final class MailingListServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge news config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/mailing-list.php',
            'mailing-list'
        );

        // Register database connection from module config
        $this->registerDatabaseConnection();
    }

    public function boot(): void
    {
        RegisterPolicies::register();
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../views', 'mailing-list-view');

        // Load routes
        if (file_exists(__DIR__.'/../../routes/web.php')) {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        }

        // Publish config
        $this->publishes([
            __DIR__.'/../../config/mailing-list.php' => config_path('mailing-list.php'),
        ], 'mailing-list-config');

        // Publish database config
        $this->publishes([
            __DIR__.'/../../config/database.php' => config_path('mailing-list-database.php'),
        ], 'mailing-list-database-config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'mailing-list-migrations');

        // Publish views
        $this->publishes([
            __DIR__.'/../../views' => resource_path('views/vendor/mailing-list'),
        ], 'mailing-list-views');

        FilamentView::registerRenderHook(
            PanelsRenderHook::TOPBAR_START,
            function (): View {
                return view('mailing-list-view::filament.topbar');
            }
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
