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

    /**
     * NOVO: Incrementa a quantidade da carta.
     */
    public function increment($entryId)
    {
        $entry = CollectionEntry::where('id', $entryId)
            ->where('user_id', auth()->id())
            ->first();

        if ($entry) {
            $entry->increment('quantity');
        }
    }

    /**
     * NOVO: Decrementa a quantidade, mas para em 1.
     */
    public function decrement($entryId)
    {
        $entry = CollectionEntry::where('id', $entryId)
            ->where('user_id', auth()->id())
            ->first();

        // Só decrementa se a quantidade for maior que 1
        if ($entry && $entry->quantity > 1) {
            $entry->decrement('quantity');
        }
    }

    /**
     * Remove um item da coleção (este já existia).
     */
    public function removeCard($collectionEntryId)
    {
        $entry = CollectionEntry::where('id', $collectionEntryId)
            ->where('user_id', auth()->id())
            ->first();

        if ($entry) {
            $entry->delete();
        }
    }

    /**
     * Renderiza o componente.
     */
    public function render()
    {
        $entries = CollectionEntry::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.collection-list', [
            'entries' => $entries,
        ]);
    }
}
