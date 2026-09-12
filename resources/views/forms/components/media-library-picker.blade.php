@php
    $statePath = $getStatePath();
    $previews = $getPreviews();
    $ids = array_column($previews, 'id');
    $modalId = 'medialibrary-picker-'.md5($statePath);
    $uploadUrl = rescue(fn (): string => \Elfeffe\Medialibrary\Resources\MediaLibraryResource::getUrl('create'), null, false);
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        class="space-y-3"
        x-on:medialibrary-picked.window="
            if ($event.detail.fieldId !== @js($statePath)) return;
            $wire.set(@js($statePath), $event.detail.ids);
            $dispatch('close-modal', { id: @js($modalId) });
        "
    >
        @if ($previews !== [])
            <ul
                wire:key="{{ $modalId }}-chips-{{ implode('-', $ids) }}"
                x-sort="(id, position) => {
                    const next = @js($ids).filter((item) => item !== id);
                    next.splice(position, 0, id);
                    $wire.set(@js($statePath), next);
                }"
                class="flex flex-wrap gap-2"
            >
                @foreach ($previews as $preview)
                    <li
                        wire:key="{{ $modalId }}-chip-{{ $preview['id'] }}"
                        x-sort:item="{{ $preview['id'] }}"
                        class="group relative size-20 cursor-grab overflow-hidden rounded-lg ring-1 ring-gray-950/10 dark:ring-white/10"
                    >
                        <img src="{{ $preview['url'] }}" alt="{{ $preview['caption'] }}" class="size-full object-cover">
                        <button
                            type="button"
                            x-on:click="$wire.set(@js($statePath), @js(array_values(array_diff($ids, [$preview['id']]))))"
                            class="absolute right-1 top-1 hidden rounded-full bg-gray-950/70 p-0.5 text-white group-hover:block"
                            aria-label="{{ __('medialibrary::picker.remove') }}"
                        >
                            <x-filament::icon icon="heroicon-m-x-mark" class="size-3.5" />
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="flex items-center gap-3">
            {{-- The id is interpolated, not `@js()`: Blade passes a component's attribute
                 through as a plain string and never expands directives inside it, so `@js`
                 here reached the browser verbatim and Alpine died on it. --}}
            <x-filament::button color="gray" icon="heroicon-m-photo" x-on:click="$dispatch('open-modal', { id: '{{ $modalId }}' })">
                {{ __('medialibrary::picker.choose_from_library') }}
            </x-filament::button>

            @if ($uploadUrl)
                <a href="{{ $uploadUrl }}" target="_blank" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-400">
                    {{ __('medialibrary::picker.upload_to_library') }}
                </a>
            @endif
        </div>

        <x-filament::modal :id="$modalId" width="5xl" :heading="__('medialibrary::picker.heading')">
            {{-- lazy: the browser queries the library when the modal opens, not on every form render. --}}
            <livewire:medialibrary.picker-browser
                :field-id="$statePath"
                :max="$getMaxItems()"
                :selected="$ids"
                wire:key="{{ $modalId }}-browser-{{ implode('-', $ids) }}"
                lazy
            />
        </x-filament::modal>
    </div>
</x-dynamic-component>
