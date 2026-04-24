<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use AcMarche\Document\Models\Document;
use AcMarche\Hrm\Models\Employee;
use AcMarche\News\Models\News;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Override;
use Throwable;

final class Homepage extends Page
{
    /**
     * @var list<array{title: string, url: string}>
     */
    public const array RSS_FEEDS = [
        ['title' => 'Le Soir', 'url' => 'https://www.lesoir.be/rss/31874/cible_principale'],
        ['title' => 'L\'Avenir Luxembourg', 'url' => 'https://www.lavenir.net/rss.aspx?foto=1&intro=1&section=zipcode&zipcode=6900'],
        ['title' => 'UVCW', 'url' => 'https://www.uvcw.be/rss/fil-rss.xml'],
        ['title' => 'DH Luxembourg', 'url' => 'https://www.dhnet.be/rss/section/regions/luxembourg.xml'],
    ];

    public Collection $latestNews;

    public Collection $latestDocuments;

    public Collection $todayBirthdays;

    /**
     * @var array<int, array{title: string, link: string, source: string, date: ?string}>
     */
    public array $rssItems = [];

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $pressArticles = [];

    #[Override]
    protected static string|null|BackedEnum $navigationIcon = Heroicon::Home;

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
        return 'Accueil';
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Screen;
    }

    public function mount(): void
    {
        $this->latestNews = News::query()
            ->latest('created_at')
            ->limit(6)
            ->get();

        $this->latestDocuments = Document::query()
            ->latest('created_at')
            ->limit(6)
            ->get();

        $this->todayBirthdays = $this->fetchTodayBirthdays();
        $this->rssItems = $this->fetchRssItems();
        $this->pressArticles = $this->fetchPressArticles();
    }

    /**
     * @return Collection<int, Employee>
     */
    private function fetchTodayBirthdays(): Collection
    {
        $today = Carbon::today();

        return Employee::query()
            ->where('show_birthday', true)
            ->whereNotNull('birth_date')
            ->whereRaw('MONTH(birth_date) = ?', [$today->month])
            ->whereRaw('DAY(birth_date) = ?', [$today->day])
            ->whereHas('activeContracts')
            ->orderBy('last_name')
            ->get();
    }

    /**
     * @return array<int, array{title: string, link: string, source: string, date: ?string}>
     */
    private function fetchRssItems(): array
    {
        return Cache::remember('homepage.rss.items', now()->addMinutes(30), function (): array {
            $items = [];

            foreach (self::RSS_FEEDS as $feed) {
                try {
                    $response = Http::timeout(5)->get($feed['url']);

                    if (! $response->successful()) {
                        continue;
                    }

                    $xml = @simplexml_load_string($response->body());

                    if ($xml === false) {
                        continue;
                    }

                    $entries = $xml->channel->item ?? $xml->entry ?? [];

                    foreach ($entries as $index => $entry) {
                        if ($index >= 5) {
                            break;
                        }

                        $items[] = [
                            'title' => mb_trim((string) ($entry->title ?? '')),
                            'link' => mb_trim((string) ($entry->link ?? '')),
                            'source' => $feed['title'],
                            'date' => (string) ($entry->pubDate ?? $entry->published ?? '') ?: null,
                        ];
                    }
                } catch (Throwable) {
                    continue;
                }
            }

            return $items;
        });
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetchPressArticles(): array
    {
        return Cache::remember('homepage.press.articles', now()->addMinutes(30), function (): array {
            try {
                $response = Http::timeout(5)->get('https://presse.marche.be/api/articles');

                if (! $response->successful()) {
                    return [];
                }

                $data = $response->json();

                return is_array($data) ? array_slice($data, 0, 6) : [];
            } catch (Throwable) {
                return [];
            }
        });
    }
}
