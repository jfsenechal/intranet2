<?php

use AcMarche\Security\Handler\MigrationHandler;
use AcMarche\Security\Repository\TabRepository;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component
{
    public function getTabsWithModules(): Collection
    {
        $tabs = TabRepository::getTabsWithModules();
        foreach ($tabs as $tab) {
            foreach ($tab->modules as $module) {
                if (! $module->is_external) {
                    if ($url = MigrationHandler::urlModule($module)) {
                        $module->url = $url;
                        $module->migrated = true;
                    } else {
                        $module->migrated = true;
                    }
                } else {
                    $module->migrated = true;
                }
            }
        }

        return $tabs;
    }
};
?>

<div>
    {{-- Trigger Button (rendered in sidebar) --}}
    <div class="mb-3 px-3">
        <button
            x-data
            x-on:click="$dispatch('toggle-modules-launcher')"
            type="button"
            class="flex w-full items-center justify-center gap-2 rounded-lg bg-warning-500 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-warning-600 focus:outline-none focus:ring-2 focus:ring-warning-400 focus:ring-offset-2 dark:bg-warning-600 dark:hover:bg-warning-500"
        >
            <x-filament::icon icon="heroicon-m-squares-2x2" class="h-5 w-5" />
            Modules
        </button>
    </div>

    @php
        $colors = [
            '#4285F4', '#EA4335', '#FBBC04', '#34A853', '#FF6D01',
            '#46BDC6', '#7B61FF', '#E91E63', '#00ACC1', '#8E24AA',
            '#43A047', '#F4511E',
        ];
    @endphp

    {{-- Modal (teleported to body via portal) --}}
    <template x-teleport="body">
        <div
            x-data="{ open: false }"
            x-on:toggle-modules-launcher.window="open = !open"
            x-on:keydown.escape.window="open = false"
        >
            {{-- Backdrop --}}
            <div
                x-show="open"
                x-on:click="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-40 bg-black/25 dark:bg-black/50"
                style="display: none;"
            ></div>

            {{-- Modal Panel --}}
            <div
                x-show="open"
                x-on:click.outside="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="scale-95 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="scale-100 opacity-100"
                x-transition:leave-end="scale-95 opacity-0"
                class="fixed inset-4 z-50 overflow-y-auto rounded-2xl bg-white p-8 shadow-2xl ring-1 ring-gray-200 sm:inset-8 dark:bg-gray-900 dark:ring-gray-700"
                style="display: none;"
            >
                {{-- Header --}}
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Applications</h2>
                    <button
                        x-on:click="open = false"
                        class="rounded-full p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                    >
                        <x-filament::icon icon="heroicon-m-x-mark" class="h-5 w-5" />
                    </button>
                </div>

                {{-- Tabs with Modules --}}
                @foreach ($this->getTabsWithModules() as $tabIndex => $tab)
                    @if ($tab->modules->isNotEmpty())
                        <div class="mb-5">
                            <h3 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                {{ $tab->name }}
                            </h3>
                            <div class="grid grid-cols-3 gap-3 sm:grid-cols-5 md:grid-cols-7 lg:grid-cols-9">
                                @foreach ($tab->modules as $moduleIndex => $module)
                                    @php
                                        $colorIndex = ($tabIndex * 3 + $moduleIndex) % count($colors);
                                        $bgColor = $colors[$colorIndex];
                                        $initials = mb_strtoupper(mb_substr($module->name, 0, 2));
                                    @endphp

                                    @if ($module->migrated)
                                        <a
                                            href="{{ $module->is_external ? $module->url : url($module->url) }}"
                                            @if ($module->is_external) target="_blank" rel="noopener noreferrer" @endif
                                            class="group flex flex-col items-center gap-1.5 rounded-xl p-3 transition hover:bg-gray-100 dark:hover:bg-gray-800"
                                            title="{{ $module->description }}"
                                        >
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-2xl text-sm font-bold text-white shadow-sm transition group-hover:scale-110 group-hover:shadow-md"
                                                style="background-color: {{ $module->color ?: $bgColor }}"
                                            >
                                                {{ $initials }}
                                            </div>
                                            <span class="max-w-full truncate text-center text-xs font-medium text-gray-700 dark:text-gray-300">
                                                {{ $module->name }}
                                            </span>
                                            @if ($module->is_external)
                                                <x-filament::icon icon="heroicon-m-arrow-top-right-on-square" class="h-3 w-3 text-gray-400" />
                                            @endif
                                        </a>
                                    @else
                                        <div
                                            class="flex flex-col items-center gap-1.5 rounded-xl p-3 opacity-40"
                                            title="{{ $module->description }}"
                                        >
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-300 text-sm font-bold text-white dark:bg-gray-600"
                                            >
                                                {{ $initials }}
                                            </div>
                                            <span class="max-w-full truncate text-center text-xs font-medium text-gray-500 dark:text-gray-500">
                                                {{ $module->name }}
                                            </span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </template>
</div>
