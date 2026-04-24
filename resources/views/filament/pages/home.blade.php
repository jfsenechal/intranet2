@php
    use AcMarche\Document\Filament\Resources\Documents\DocumentResource;
    use AcMarche\News\Filament\Resources\News\NewsResource;
    use Illuminate\Support\Facades\Storage;
@endphp

<x-filament-panels::page>
    <style>
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 0.7; }
            80%, 100% { transform: scale(1.4); opacity: 0; }
        }

        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out both; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-pulse-ring::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: currentColor;
            animation: pulse-ring 1.8s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgb(0 0 0 / 0.15);
        }

        .gradient-sport {
            background: linear-gradient(135deg, #f97316 0%, #ef4444 50%, #ec4899 100%);
        }
        .gradient-birthday {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #ef4444 100%);
        }
        .gradient-news {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        }
        .gradient-documents {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
        }
        .gradient-rss {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        }
        .gradient-press {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
        }

        [style*="--delay"] { animation-delay: var(--delay); }
    </style>

    <div class="w-full space-y-8">
        {{-- Hero banner --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-500 via-primary-600 to-primary-800 p-8 text-white shadow-2xl animate-fade-in-up">
            <div class="absolute -right-10 -top-10 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-10 h-72 w-72 rounded-full bg-white/5 blur-3xl"></div>
            <div class="relative">
                <p class="text-sm font-medium uppercase tracking-wider opacity-80">
                    {{ \Illuminate\Support\Carbon::now()->translatedFormat('l d F Y') }}
                </p>
                <h1 class="mt-2 text-4xl font-extrabold md:text-5xl">Bienvenue sur l'intranet</h1>
                <p class="mt-3 max-w-2xl text-lg opacity-90">
                    Votre portail central pour les actualités, documents et informations du personnel.
                </p>
            </div>
        </div>

        {{-- Top row: Birthdays + Sports --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Birthdays --}}
            <div class="card-hover overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-gray-800 animate-fade-in-up" style="--delay: 0.1s">
                <div class="gradient-birthday flex items-center gap-3 p-6 text-white">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A2.704 2.704 0 003 15.546V21h18v-5.454zM12 3v2m0 2a2 2 0 100-4 2 2 0 000 4zm0 0v6m-3 4h6" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Ils sont nés ce {{ \Illuminate\Support\Carbon::today()->translatedFormat('d F') }}</h2>
                        <p class="text-sm opacity-90">
                            {{ $todayBirthdays->count() }} {{ $todayBirthdays->count() > 1 ? 'personnes fêtent' : 'personne fête' }} son anniversaire
                        </p>
                    </div>
                </div>
                <div class="p-6">
                    @forelse ($todayBirthdays as $index => $employee)
                        <div class="flex items-center gap-4 border-b border-gray-100 py-3 last:border-0 dark:border-gray-800 animate-fade-in-up" style="--delay: {{ 0.2 + ($index * 0.05) }}s">
                            <div class="relative">
                                @if ($employee->photo && Storage::disk('public')->exists($employee->photo))
                                    <img
                                        src="{{ Storage::disk('public')->url($employee->photo) }}"
                                        alt="{{ $employee->first_name }} {{ $employee->last_name }}"
                                        class="h-14 w-14 rounded-full object-cover ring-2 ring-amber-400"
                                    />
                                @else
                                    <img
                                        src="https://ui-avatars.com/api/?size=128&background=fbbf24&color=fff&name={{ urlencode(trim($employee->first_name.' '.$employee->last_name)) }}"
                                        alt="{{ $employee->first_name }} {{ $employee->last_name }}"
                                        class="h-14 w-14 rounded-full object-cover ring-2 ring-amber-400"
                                    />
                                @endif
                                <span class="absolute -right-1 -top-1 text-xl animate-float">🎂</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                </p>
                                @if ($employee->activeContracts->first()?->job_title)
                                    <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                                        {{ $employee->activeContracts->first()->job_title }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <span class="text-4xl">🎈</span>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Aucun anniversaire aujourd'hui.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Sports --}}
            <div class="card-hover relative overflow-hidden rounded-2xl shadow-lg animate-fade-in-up" style="--delay: 0.15s">
                <div class="gradient-sport absolute inset-0"></div>
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22><g fill=%22none%22 fill-rule=%22evenodd%22><g fill=%22%23fff%22 fill-opacity=%220.08%22><path d=%22M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%22/></g></g></svg>')]"></div>
                <div class="relative flex min-h-[280px] flex-col justify-between p-8 text-white">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur animate-float">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider backdrop-blur">Pour le personnel</span>
                    </div>
                    <div>
                        <h2 class="text-4xl font-extrabold leading-tight md:text-5xl">
                            Activités sportives
                        </h2>
                        <p class="mt-2 text-xl opacity-90">pour le personnel</p>
                    </div>
                    <div class="flex items-center gap-4 text-6xl">
                        <span class="animate-float" style="--delay: 0s">⚽</span>
                        <span class="animate-float" style="animation-delay: 0.3s">🏃</span>
                        <span class="animate-float" style="animation-delay: 0.6s">🏋️</span>
                        <span class="animate-float" style="animation-delay: 0.9s">🚴</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Middle row: News + Documents --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Latest news --}}
            <div class="card-hover overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-gray-800 animate-fade-in-up" style="--delay: 0.2s">
                <div class="gradient-news flex items-center justify-between p-5 text-white">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold">Dernières actualités</h2>
                    </div>
                    <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur">
                        {{ $latestNews->count() }}
                    </span>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($latestNews as $index => $news)
                        <a
                            href="{{ NewsResource::getUrl('view', ['record' => $news->id], panel: 'news') }}"
                            class="group flex items-start gap-3 p-4 transition hover:bg-gray-50 dark:hover:bg-gray-800 animate-fade-in-up"
                            style="--delay: {{ 0.3 + ($index * 0.05) }}s"
                        >
                            <div class="mt-1 h-2 w-2 flex-shrink-0 rounded-full bg-blue-500 group-hover:animate-pulse"></div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-medium text-gray-900 group-hover:text-primary-600 dark:text-gray-100">
                                    {{ $news->title ?? $news->name }}
                                </p>
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $news->created_at?->translatedFormat('d F Y') }}
                                    @if ($news->user_add)
                                        — {{ $news->user_add }}
                                    @endif
                                </p>
                            </div>
                        </a>
                    @empty
                        <p class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">Aucune actualité récente.</p>
                    @endforelse
                </div>
            </div>

            {{-- Latest documents --}}
            <div class="card-hover overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-gray-800 animate-fade-in-up" style="--delay: 0.25s">
                <div class="gradient-documents flex items-center justify-between p-5 text-white">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold">Derniers documents</h2>
                    </div>
                    <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur">
                        {{ $latestDocuments->count() }}
                    </span>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($latestDocuments as $index => $document)
                        <a
                            href="{{ DocumentResource::getUrl('view', ['record' => $document->id], panel: 'document-panel') }}"
                            class="group flex items-start gap-3 p-4 transition hover:bg-gray-50 dark:hover:bg-gray-800 animate-fade-in-up"
                            style="--delay: {{ 0.35 + ($index * 0.05) }}s"
                        >
                            <div class="mt-1 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 group-hover:scale-110 transition-transform dark:bg-emerald-900/30 dark:text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-medium text-gray-900 group-hover:text-primary-600 dark:text-gray-100">
                                    {{ $document->name }}
                                </p>
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $document->created_at?->translatedFormat('d F Y') }}
                                    @if ($document->file_name)
                                        — {{ $document->file_name }}
                                    @endif
                                </p>
                            </div>
                        </a>
                    @empty
                        <p class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">Aucun document récent.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Bottom row: RSS + Press --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- RSS feed --}}
            <div class="card-hover overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-gray-800 animate-fade-in-up" style="--delay: 0.3s">
                <div class="gradient-rss flex items-center gap-3 p-5 text-white">
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5.5 18a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM.5 10.5v3.5a9 9 0 019 9h3.5A12.5 12.5 0 00.5 10.5zm0-7v3.5A16 16 0 0116.5 23H20A19.5 19.5 0 00.5 3.5z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold">Flux d'actualité</h2>
                </div>
                <div class="max-h-[500px] overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($rssItems as $index => $item)
                        <a
                            href="{{ $item['link'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group block p-4 transition hover:bg-gray-50 dark:hover:bg-gray-800 animate-fade-in-up"
                            style="--delay: {{ 0.4 + ($index * 0.03) }}s"
                        >
                            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-purple-600 dark:text-purple-400">
                                {{ $item['source'] }}
                            </p>
                            <p class="line-clamp-2 text-sm font-medium text-gray-900 group-hover:text-primary-600 dark:text-gray-100">
                                {{ $item['title'] }}
                            </p>
                            @if ($item['date'])
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Illuminate\Support\Carbon::parse($item['date'])->translatedFormat('d F Y à H:i') }}
                                </p>
                            @endif
                        </a>
                    @empty
                        <p class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">Aucun flux disponible.</p>
                    @endforelse
                </div>
            </div>

            {{-- Press release --}}
            <div class="card-hover overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-gray-800 animate-fade-in-up" style="--delay: 0.35s">
                <div class="gradient-press flex items-center gap-3 p-5 text-white">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold">Revue de presse</h2>
                </div>
                <div class="max-h-[500px] overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($pressArticles as $index => $article)
                        <a
                            href="{{ $article['url'] ?? $article['link'] ?? '#' }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group block p-4 transition hover:bg-gray-50 dark:hover:bg-gray-800 animate-fade-in-up"
                            style="--delay: {{ 0.45 + ($index * 0.03) }}s"
                        >
                            <p class="line-clamp-2 text-sm font-semibold text-gray-900 group-hover:text-primary-600 dark:text-gray-100">
                                {{ $article['title'] ?? $article['name'] ?? 'Article' }}
                            </p>
                            @if (! empty($article['source']) || ! empty($article['publisher']))
                                <p class="mt-1 text-xs font-medium uppercase tracking-wide text-cyan-600 dark:text-cyan-400">
                                    {{ $article['source'] ?? $article['publisher'] }}
                                </p>
                            @endif
                            @if (! empty($article['publishedAt']) || ! empty($article['published_at']) || ! empty($article['date']))
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Illuminate\Support\Carbon::parse($article['publishedAt'] ?? $article['published_at'] ?? $article['date'])->translatedFormat('d F Y') }}
                                </p>
                            @endif
                        </a>
                    @empty
                        <p class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">Aucun article de presse disponible.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
