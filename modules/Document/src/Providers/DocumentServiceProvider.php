<?php

declare(strict_types=1);

namespace AcMarche\Document\Providers;

use AcMarche\App\Traits\ModuleServiceProviderTrait;
use Illuminate\Support\ServiceProvider;

final class DocumentServiceProvider extends ServiceProvider
{
    use ModuleServiceProviderTrait;

    public function register(): void
    {
        $this->registerModuleConfig();
    }

    public function boot(): void
    {
        $this->bootModule();
    }

    protected function moduleName(): string
    {
        return 'document';
    }
}
