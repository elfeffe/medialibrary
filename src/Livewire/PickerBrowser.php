<?php

declare(strict_types=1);

namespace Elfeffe\Medialibrary\Livewire;

use Elfeffe\Medialibrary\Forms\Components\MediaLibraryPicker;
use Elfeffe\Medialibrary\Models\MediaLibrary;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * The grid inside MediaLibraryPicker's modal: library images, searchable by caption,
 * multi-select in click order. "Use" hands the ids back to the field that opened it.
 */
class PickerBrowser extends Component
{
    use WithPagination;

    #[Locked]
    public string $fieldId = '';

    /** 0 = no limit. */
    #[Locked]
    public int $max = 0;

    /** @var list<int> */
    public array $selected = [];

    public string $search = '';

    /**
     * @param  array<int, mixed>  $selected
     */
    public function mount(string $fieldId, int $max = 0, array $selected = []): void
    {
        $this->fieldId = $fieldId;
        $this->max = max(0, $max);
        $this->selected = MediaLibraryPicker::normalizeIds($selected);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function items(): LengthAwarePaginator
    {
        $search = trim($this->search);

        return MediaLibrary::query()
            ->with('media')
            ->whereHas('media', fn ($query) => $query->where('mime_type', 'like', 'image/%'))
            ->when($search !== '', fn ($query) => $query->where('caption', 'like', "%{$search}%"))
            ->latest('id')
            ->paginate(24);
    }

    public function toggle(int $id): void
    {
        if (in_array($id, $this->selected, true)) {
            $this->selected = array_values(array_diff($this->selected, [$id]));

            return;
        }

        if ($this->max === 1) {
            $this->selected = [$id];

            return;
        }

        if ($this->max > 0 && count($this->selected) >= $this->max) {
            return;
        }

        $this->selected[] = $id;
    }

    public function confirm(): void
    {
        $this->dispatch('medialibrary-picked', fieldId: $this->fieldId, ids: $this->selected);
    }

    public function render(): View
    {
        return view('medialibrary::livewire.picker-browser');
    }
}
