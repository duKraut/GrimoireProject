<?php

namespace App\Providers;

use App\Interfaces\CollectionEntryRepositoryInterface;
use App\Interfaces\DeckCardRepositoryInterface;
use App\Interfaces\DeckRepositoryInterface;
use App\Interfaces\FormatRepositoryInterface;
use App\Repositories\CollectionEntryRepository;
use App\Repositories\DeckCardRepository;
use App\Repositories\DeckRepository;
use App\Repositories\FormatRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(CollectionEntryRepositoryInterface::class, CollectionEntryRepository::class);

        // $this->app->bind(DeckRepositoryInterface::class, DeckRepository::class);

        // $this->app->bind(FormatRepositoryInterface::class, FormatRepository::class);

        // $this->app->bind(DeckCardRepositoryInterface::class, DeckCardRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
