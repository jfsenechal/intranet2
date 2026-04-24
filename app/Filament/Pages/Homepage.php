<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use AcMarche\Document\Models\Document;
use AcMarche\News\Models\News;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Override;

final class Homepage extends Page
{
    public Collection $latestNews;

    public Collection $latestDocuments;

    public Collection $ownedCourriers;

    #[Override]
    protected static string|null|BackedEnum $navigationIcon = Heroicon::DocumentText;

    #[Override]
    protected string $view = 'filament.pages.home';

    #[Override]
    protected static ?string $navigationLabel = 'Accueil';

    #[Override]
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return 'Accueil';
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public function getTitle(): string
    {
        return 'Accueil ';
    }

    public function getLayout(): string
    {
        return self::$layout ?? 'filament-panels::components.layout.base';
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Screen;
    }

    public function getColumns(): int
    {
        return 2;
    }

    public const array RSS_FEEDS = [
        'lesoir' => 'https://www.lesoir.be/rss/31874/cible_principale',
        'avenir' => 'https://www.lavenir.net/rss.aspx?foto=1&intro=1&section=zipcode&zipcode=6900',
        'uvcw' => 'https://www.uvcw.be/rss/fil-rss.xml',
        'dhnet' => 'https://www.dhnet.be/rss/section/regions/luxembourg.xml',
    ];

    protected function pressRelease(): array
    {
        $response = $this->httpClient->request('GET', 'https://presse.marche.be/api/articles');
        $dataString = $response->getContent();
        $data = json_decode($dataString, flags: JSON_THROW_ON_ERROR);
        if (is_array($data)) {
            return ['title' => 'Revue de presse', 'items' => $data];
        }

        return [];
    }

    public function mount(): void
    {
        /**
         * add rss
         */

        $this->latestNews = News::query()
            ->latest('created_at')
            ->limit(5)
            ->get();

        $this->latestDocuments = Document::query()
            ->latest('created_at')
            ->limit(5)
            ->get();
    }
}
