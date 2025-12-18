<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EloquentUserRepository;
use App\Repositories\Contracts\CollectionRepositoryInterface;
use App\Repositories\EloquentCollectionRepository;
use App\Repositories\Contracts\FlashcardRepositoryInterface;
use App\Repositories\EloquentFlashcardRepository;
use App\Repositories\Contracts\AvatarRepositoryInterface;
use App\Repositories\EloquentAvatarRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(CollectionRepositoryInterface::class, EloquentCollectionRepository::class);
        $this->app->bind(FlashcardRepositoryInterface::class, EloquentFlashcardRepository::class);
        $this->app->bind(AvatarRepositoryInterface::class, EloquentAvatarRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
