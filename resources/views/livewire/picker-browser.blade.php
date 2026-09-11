<div class="space-y-4">
    <x-filament::input.wrapper prefix-icon="heroicon-m-magnifying-glass">
        <x-filament::input type="search" wire:model.live.debounce.300ms="search" :placeholder="__('Search by caption')" />
    </x-filament::input.wrapper>

    <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 lg:grid-cols-6">
        @forelse ($this->items as $item)
            @php
                $media = $item->getItem();
                $position = array_search($item->id, $selected, true);
            @endphp
            <button
                type="button"
                wire:key="medialibrary-item-{{ $item->id }}"
                wire:click="toggle({{ $item->id }})"
                @class([
                    'relative aspect-square overflow-hidden rounded-lg transition',
                    'ring-2 ring-primary-600 dark:ring-primary-500' => $position !== false,
                    'ring-1 ring-gray-950/10 hover:ring-primary-500 dark:ring-white/10' => $position === false,
                ])
            >
                @if ($media)
                    <img src="{{ $media->getFullUrl() }}" alt="{{ $item->caption }}" loading="lazy" class="size-full object-cover">
                @endif

                @if ($position !== false)
                    <span class="absolute right-1.5 top-1.5 flex size-5 items-center justify-center rounded-full bg-primary-600 text-xs font-semibold text-white dark:bg-primary-500 dark:text-gray-950">
                        {{ $position + 1 }}
                    </span>
                @endif
            </button>
        @empty
            <p class="col-span-full py-10 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('No images in the library yet.') }}</p>
        @endforelse
    </div>

    <x-filament::pagination :paginator="$this->items" />

    <div class="flex justify-end">
        <x-filament::button wire:click="confirm">
            {{ __('Use :count selected', ['count' => count($selected)]) }}
        </x-filament::button>
    </div>
</div>
