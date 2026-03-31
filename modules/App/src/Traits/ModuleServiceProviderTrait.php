<?php

declare(strict_types=1);

namespace AcMarche\App\Traits;

trait ModuleServiceProviderTrait
{
    /**
     * The module name (e.g. 'courrier', 'hrm', 'news').
     */
    abstract protected function moduleName(): string;

    /**
     * The base path of the module (directory containing config/, database/, resources/, routes/).
     */
    abstract protected function modulePath(): string;

    protected function registerModuleConfig(): void
    {
        $name = $this->moduleName();

        $this->mergeConfigFrom(
            $this->modulePath()."/config/{$name}.php",
            $name
        );

        $this->registerDatabaseConnection();
    }

    protected function bootModule(): void
    {
        $name = $this->moduleName();
        $path = $this->modulePath();

        $this->loadMigrationsFrom($path.'/database/migrations');
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
            $path.'/database/migrations' => database_path('migrations'),
        ], "{$name}-migrations");

        $this->publishes([
            $path.'/resources/views' => resource_path("views/vendor/{$name}"),
        ], "{$name}-views");
    }

    protected function registerDatabaseConnection(): void
    {
        $connections = require $this->modulePath().'/config/database.php';

        foreach ($connections['connections'] ?? [] as $name => $config) {
            config(['database.connections.'.$name => $config]);
        }
    }
}
