<?php

declare(strict_types=1);

namespace AcMarche\Security\Providers;

use AcMarche\App\Traits\ModuleServiceProviderTrait;
use AcMarche\Security\Console\Commands\CreateUserCommand;
use AcMarche\Security\Console\Commands\MigrationRoleCommand;
use AcMarche\Security\Console\Commands\SyncUserCommand;
use Illuminate\Support\ServiceProvider;

final class SecurityServiceProvider extends ServiceProvider
{
    use ModuleServiceProviderTrait;

    public function register(): void
    {
        $this->registerModuleConfig();
    }

    public function boot(): void
    {
        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateUserCommand::class,
                SyncUserCommand::class,
                MigrationRoleCommand::class,
            ]);
        }

        // Custom boot without migrations (Security module has no migrations)
        $path = $this->modulePath();
        $name = $this->moduleName();

        $this->loadViewsFrom($path.'/resources/views', $name);

        if (file_exists($path.'/routes/web.php')) {
            $this->loadRoutesFrom($path.'/routes/web.php');
        }

        $this->publishes([
            $path."/config/{$name}.php" => config_path("{$name}.php"),
        ], "{$name}-config");

        $this->publishes([
            $path.'/config/database.php' => config_path("{$name}-database.php"),
        ], "{$name}-database-config");

        $this->publishes([
            $path.'/resources/views' => resource_path("views/vendor/{$name}"),
        ], "{$name}-views");

        $this->publishes([
            $path.'/resources/assets' => public_path("vendor/{$name}"),
        ], "{$name}-assets");
    }

    protected function moduleName(): string
    {
        return 'security';
    }

    protected function modulePath(): string
    {
        return __DIR__.'/../..';
    }
}
