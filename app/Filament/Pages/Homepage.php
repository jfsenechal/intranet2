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
    #[\Override]
    protected static string|null|BackedEnum $navigationIcon = Heroicon::DocumentText;

    #[\Override]
    protected string $view = 'filament.pages.home';

    #[\Override]
    protected static ?string $navigationLabel = 'Accueil';

    #[\Override]
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

    public function getTitle(): string
    {
        return 'Accueil ';
    }

    public function getLayout(): string
    {
        return self::$layout ?? 'filament-panels::components.layout.base';
    }

    public function getMaxContentWidth(): \Filament\Support\Enums\Width
    {
        return Width::Screen;
    }

    public function getColumns(): int
    {
        return 2;
    }
}
