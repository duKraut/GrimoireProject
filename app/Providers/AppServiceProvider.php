<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CollectionEntryRepositoryInterface;
use App\Repositories\CollectionEntryRepository;
use App\Interfaces\DeckRepositoryInterface;
use App\Repositories\DeckRepository;
use App\Interfaces\FormatRepositoryInterface;
use App\Repositories\FormatRepository;
use App\Interfaces\DeckCardRepositoryInterface;
use App\Repositories\DeckCardRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CollectionEntryRepositoryInterface::class, CollectionEntryRepository::class);

        $this->app->bind(DeckRepositoryInterface::class, DeckRepository::class);

        $this->app->bind(FormatRepositoryInterface::class, FormatRepository::class);

        $this->app->bind(DeckCardRepositoryInterface::class, DeckCardRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}