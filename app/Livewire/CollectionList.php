<?php

namespace App\Livewire;

use App\Models\CollectionEntry;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CollectionList extends Component
{
    use WithPagination;

    #[On('card-added')]
    public function refreshCollection()
    {
        $this->resetPage();
    }

    public function removeCard($collectionEntryId)
    {
        $entry = CollectionEntry::where('id', $collectionEntryId)
            ->where('user_id', auth()->id())
            ->first();

        if ($entry) {
            $entry->delete();
        }
    }

    public function render()
    {
        $entries = CollectionEntry::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('livewire.collection-list', [
            'entries' => $entries,
        ]);
    }
}
