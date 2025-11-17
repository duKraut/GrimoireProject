<?php

namespace App\Livewire;

use App\Interfaces\CollectionEntryRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CollectionList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $showDeleteModal = false;

    public ?int $cardToDelete = null;

    #[On('refresh-collection')]
    public function reloadEntries()
    {
        $this->resetPage();
    }

    public function confirmRemoval(int $entryId)
    {
        $this->cardToDelete = $entryId;
        $this->showDeleteModal = true;
    }

    public function cancelRemoval()
    {
        $this->showDeleteModal = false;
        $this->cardToDelete = null;
    }

    public function deleteCard()
    {
        if ($this->cardToDelete) {
            $this->removeCard($this->cardToDelete);
        }

        $this->showDeleteModal = false;
        $this->cardToDelete = null;
    }

    public function removeCard(int $entryId)
    {
        app(CollectionEntryRepositoryInterface::class)
            ->deleteEntry($entryId);

        $this->dispatch('card-removed', 'Carta removida da coleção.');
    }

    public function increment(int $entryId)
    {
        app(CollectionEntryRepositoryInterface::class)
            ->incrementQuantity($entryId);
    }

    public function decrement(int $entryId)
    {
        app(CollectionEntryRepositoryInterface::class)
            ->decrementQuantity($entryId);
    }

    public function render()
    {
        $entries = app(CollectionEntryRepositoryInterface::class)
            ->getUserEntriesPaginated(Auth::id(), 10);

        return view('livewire.collection-list', [
            'entries' => $entries,
        ]);
    }
}
