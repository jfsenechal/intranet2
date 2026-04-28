@php
    /** @var \AcMarche\Hrm\Models\Employee $employee */
    $fullName = mb_trim(($employee->first_name ?? '') . ' ' . ($employee->last_name ?? ''));
    $jobTitles = $employee->activeContracts
        ->pluck('job_title')
        ->filter()
        ->unique()
        ->values();
    $services = $employee->activeContracts
        ->pluck('service.name')
        ->filter()
        ->unique()
        ->values();
    $photoUrl = $employee->photo
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($employee->photo)
        : 'https://ui-avatars.com/api/?size=160&name=' . urlencode($fullName !== '' ? $fullName : '?');
    $phoneDisplay = $employee->professional_phone
        ? trim($employee->professional_phone . ($employee->professional_phone_extension ? ' (ext. ' . $employee->professional_phone_extension . ')' : ''))
        : null;
@endphp

<div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4 shadow-sm flex gap-4">
    <img src="{{ $photoUrl }}"
         alt="{{ $fullName }}"
         class="h-24 w-24 rounded-full object-cover flex-shrink-0 bg-gray-100 dark:bg-gray-800" />

    <div class="flex-1 min-w-0">
        <div class="text-base font-semibold text-gray-900 dark:text-gray-100 truncate">
            {{ $employee->last_name }} {{ $employee->first_name }}
        </div>

        @if ($jobTitles->isNotEmpty())
            <div class=" text-gray-700 dark:text-gray-300 mt-0.5">
                {{ $jobTitles->implode(', ') }}
            </div>
        @endif

        @if ($services->isNotEmpty())
            <div class=" text-primary-600 dark:text-primary-400 mt-0.5">
                {{ $services->implode(', ') }}
            </div>
        @endif

        <div class="mt-2 space-y-0.5  text-gray-600 dark:text-gray-400">
            @if ($employee->professional_email)
                <div class="flex items-center gap-1 truncate">
                    <x-filament::icon icon="heroicon-o-envelope" class="h-3.5 w-3.5 flex-shrink-0" />
                    <a href="mailto:{{ $employee->professional_email }}"
                       class="text-primary-600 dark:text-primary-400 hover:underline truncate">
                        {{ $employee->professional_email }}
                    </a>
                </div>
            @endif

            @if ($phoneDisplay)
                <div class="flex items-center gap-1">
                    <x-filament::icon icon="heroicon-o-phone" class="h-3.5 w-3.5 shrink-0" />
                    <span>{{ $phoneDisplay }}</span>
                </div>
            @endif

            @if ($employee->professional_mobile)
                <div class="flex items-center gap-1">
                    <x-filament::icon icon="heroicon-o-device-phone-mobile" class="h-3.5 w-3.5 shrink-0" />
                    <a href="tel:{{ $employee->professional_mobile }}"
                       class="text-primary-600 dark:text-primary-400 hover:underline">
                        {{ $employee->professional_mobile }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
