<?php

declare(strict_types=1);

namespace AcMarche\App\Traits;

use closure;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;

trait HooksTrait
{
    public function buttonListModules(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_NAV_START,
            fn (): View => view('app::filament.list-modules-button'),
        );
    }

    public function currentModuleName(string $name): closure
    {
        return fn (): string => "zeze";
        return fn (): string => view('app::filament.topbar-module-name', ['moduleName' => $name])->render();

        FilamentView::registerRenderHook(
            PanelsRenderHook::TOPBAR_START,
            function (): View {
                return view('mailing-list::filament.topbar');
            },
            scopes: 'mailing-list',
        );
    }
}
