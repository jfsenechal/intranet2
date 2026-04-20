<x-filament-panels::page>
    <x-slot name="title">
        Signature email
    </x-slot>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button type="submit">
                Enregistrer
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
