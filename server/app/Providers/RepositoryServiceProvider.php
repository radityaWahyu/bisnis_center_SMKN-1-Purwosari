<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\DepartementInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\PostInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\ImageInterface;
use App\Repositories\Interfaces\ReviewInterface;
use App\Repositories\Interfaces\AuthInterface;
use App\Repositories\Interfaces\CountInterface;
use App\Repositories\Interfaces\GalleryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\DepartementRepository;
use App\Repositories\UserRepository;
use App\Repositories\ImageRepository;
use App\Repositories\ItemRepository;
use App\Repositories\PostRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\AuthRepository;
use App\Repositories\CountRepository;
use App\Repositories\GalleryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(DepartementInterface::class, DepartementRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(ImageInterface::class, ImageRepository::class);
        $this->app->bind(ItemInterface::class, ItemRepository::class);
        $this->app->bind(PostInterface::class, PostRepository::class);
        $this->app->bind(ReviewInterface::class, ReviewRepository::class);
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(CountInterface::class, CountRepository::class);
        $this->app->bind(GalleryInterface::class, GalleryRepository::class);
    }
}
