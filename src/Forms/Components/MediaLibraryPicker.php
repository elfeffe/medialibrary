<?php

declare(strict_types=1);

namespace Elfeffe\Medialibrary\Forms\Components;

use Closure;
use Elfeffe\Medialibrary\Models\MediaLibrary;
use Filament\Forms\Components\Field;

/**
 * An ordered list of MediaLibrary ids chosen from the library in a modal.
 * State: list<int>, first id first. Thumbnails are reorderable and removable.
 */
class MediaLibraryPicker extends Field
{
    protected string $view = 'medialibrary::forms.components.media-library-picker';

    protected bool|Closure $isMultiple = false;

    protected int|Closure|null $maxItems = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->default([]);

        $this->afterStateHydrated(static function (MediaLibraryPicker $component, mixed $state): void {
            $component->state(static::normalizeIds($state));
        });

        $this->dehydrateStateUsing(static fn (mixed $state): array => static::normalizeIds($state));
    }

    public function multiple(bool|Closure $condition = true): static
    {
        $this->isMultiple = $condition;

        return $this;
    }

    public function maxItems(int|Closure|null $count): static
    {
        $this->maxItems = $count;

        return $this;
    }

    public function isMultiple(): bool
    {
        return (bool) $this->evaluate($this->isMultiple);
    }

    /** 1 for a single picker; 0 means no limit. */
    public function getMaxItems(): int
    {
        if (! $this->isMultiple()) {
            return 1;
        }

        return max(0, (int) $this->evaluate($this->maxItems));
    }

    /**
     * @return list<array{id: int, url: string, caption: string}>
     */
    public function getPreviews(): array
    {
        $ids = static::normalizeIds($this->getState());

        if ($ids === []) {
            return [];
        }

        $rows = MediaLibrary::query()->with('media')->whereKey($ids)->get()->keyBy('id');
        $previews = [];

        foreach ($ids as $id) {
            $row = $rows->get($id);
            $media = $row?->getItem();

            if ($media === null) {
                continue;
            }

            $previews[] = [
                'id' => $id,
                'url' => $media->getFullUrl(),
                'caption' => (string) ($row->caption ?: $media->name),
            ];
        }

        return $previews;
    }

    /**
     * @return list<int>
     */
    public static function normalizeIds(mixed $state): array
    {
        return MediaIds::normalize($state);
    }
}
