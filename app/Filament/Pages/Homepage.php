<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use AcMarche\Security\Handler\MigrationHandler;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

final class Homepage extends Page
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::DocumentText;

    protected string $view = 'filament.pages.home';

    protected static ?string $navigationLabel = 'Accueil';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return 'Accueil';
    }

    public static function canAccess(): bool
    {
        return true;
    }

    /**
     * Get all tabs with their modules
     */
    public static function getTabsWithModules(): Collection
    {
        return MigrationHandler::getTabsWithModules();
    }

    public function getTitle(): string|Htmlable
    {
        return 'Accueil ';
    }

    public function getLayout(): string
    {
        return self::$layout ?? 'filament-panels::components.layout.base';
    }

    public function getMaxContentWidth(): Width|null|string
    {
        return Width::Screen;
    }

    public function getColumns(): int|string|array
    {
        return 2;
    }
}
