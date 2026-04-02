<?php

declare(strict_types=1);

namespace AcMarche\News\Providers;

use AcMarche\App\Traits\ModuleServiceProviderTrait;
use AcMarche\News\Models\Category;
use AcMarche\News\Models\News;
use AcMarche\News\Policies\CategoryPolicy;
use AcMarche\News\Policies\NewsPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

final class NewsServiceProvider extends ServiceProvider
{
    use ModuleServiceProviderTrait;

    public static int $module_id = 15;

    /**
     * @var array<class-string, class-string>
     */
    protected array $policies = [
        Category::class => CategoryPolicy::class,
        News::class => NewsPolicy::class,
    ];

    public function register(): void
    {
        $this->registerModuleConfig();
    }

    public function boot(): void
    {
        $this->bootModule();
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    protected function moduleName(): string
    {
        return 'news';
    }

    protected function modulePath(): string
    {
        return __DIR__.'/../..';
    }
}
