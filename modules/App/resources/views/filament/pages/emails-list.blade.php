<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Services</x-slot>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left">
                    <th class="py-2 pr-4">Nom</th>
                    <th class="py-2 pr-4">Mail</th>
                    <th class="py-2">Adresses alternatives</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr class="border-t border-gray-200 dark:border-gray-700 align-top">
                        <td class="py-2 pr-4">{{ $service->getFirstAttribute('cn') }}</td>
                        <td class="py-2 pr-4">
                            <a href="mailto:{{ $service->getFirstAttribute('mail') }}" class="text-primary-600 hover:underline">
                                {{ $service->getFirstAttribute('mail') }}
                            </a>
                        </td>
                        <td class="py-2">
                            @foreach ((array) $service->getAttribute('proxyaddresses') as $address)
                                <div>{{ $address }}</div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">Listes</x-slot>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left">
                    <th class="py-2 pr-4">Mail</th>
                    <th class="py-2">Destinataires</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lists as $list)
                    @php
                        $mail = $list->getFirstAttribute('mail');
                        $description = $list->getFirstAttribute('description');
                        $addresses = (array) $list->getAttribute('proxyaddresses');
                    @endphp
                    <tr class="border-t border-gray-200 dark:border-gray-700 align-top">
                        <td class="py-2 pr-4">
                            @if ($mail)
                                <a href="mailto:{{ $mail }}" class="text-primary-600 hover:underline">{{ $mail }}</a>
                            @endif
                            @if ($description)
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $description }}</div>
                            @endif
                        </td>
                        <td class="py-2">
                            @if ($addresses !== [])
                                <x-filament::dropdown placement="bottom-start">
                                    <x-slot name="trigger">
                                        <button type="button" class="text-primary-600 hover:underline">
                                            Voir ({{ count($addresses) }})
                                        </button>
                                    </x-slot>

                                    <div class="p-3 space-y-1">
                                        @foreach ($addresses as $address)
                                            <div>{{ $address }}</div>
                                        @endforeach
                                    </div>
                                </x-filament::dropdown>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::section>
</x-filament-panels::page>
