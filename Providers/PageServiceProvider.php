<?php

namespace Modules\Page\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\CollectingAssets;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Media\Image\ThumbnailManager;
use Modules\Page\Entities\Page;
use Modules\Page\Entities\PageTranslation;
use Modules\Page\Events\Handlers\CheckTranslations;
use Modules\Page\Events\Handlers\ResetChildren;
use Modules\Page\Events\Handlers\UpdateChildren;
use Modules\Page\Events\Handlers\UpdateMenu;
use Modules\Page\Facades\PageFacade;
use Modules\Page\Observers\MenuObserver;
use Modules\Page\Observers\SortObserver;
use Modules\Page\Observers\UriObserver;
use Modules\Page\Repositories\Cache\CachePageDecorator;
use Modules\Page\Repositories\Eloquent\EloquentPageRepository;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Services\FinderService;
use Modules\Page\Events\Handlers\RegisterPageSidebar;
use Modules\Tag\Repositories\TagManager;

class PageServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerFacade();

        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('page', RegisterPageSidebar::class)
        );
    }

    public function boot()
    {
        if(setting('page::intro-page')) {
            \Route::get('/', 'Modules\Page\Http\Controllers\PublicController@intro');
        }

        $this->publishConfig('page', 'config');
        $this->publishConfig('page', 'permissions');
        $this->publishConfig('page', 'settings');

        $this->app[TagManager::class]->registerNamespace(new Page());
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Page::observe(SortObserver::class);
        Page::observe(MenuObserver::class);
        PageTranslation::observe(UriObserver::class);

        //$this->registerThumbnails();

        $this->handleAssets();

        \Validator::extend('is_home', 'Modules\Page\Validators\PageValidator@validateIsHome');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(FinderService::class, function () {
            return new FinderService();
        });

        $this->registerEvents();

        $this->app->bind(PageRepository::class, function () {
            $repository = new EloquentPageRepository(new Page());

            if (!Config::get('app.cache')) {
                return $repository;
            }

            return new CachePageDecorator($repository);
        }
        );
    }

    /**
     * Require iCheck on edit and create pages
     */
    private function handleAssets()
    {
        $this->app['events']->listen(CollectingAssets::class, function (CollectingAssets $event) {
            if ($event->onRoutes(['*page*create', '*page*edit'])) {
                $event->requireCss('icheck.blue.css');
                $event->requireJs('icheck.js');
            }
        });
    }

    private function registerEvents()
    {
        $this->app->events->subscribe(new ResetChildren());
        $this->app->events->subscribe(new UpdateMenu());
        $this->app->events->subscribe(new UpdateChildren());
        $this->app->events->subscribe(new CheckTranslations());
    }

    private function registerThumbnails()
    {
        $this->app[ThumbnailManager::class]->registerThumbnail('pageThumb', [
            'resize' => [
                'width'    => '200',
                'height'   => null,
                'callback' => function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                },
            ],
        ]);
    }

    private function registerFacade()
    {
        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Page', PageFacade::class);
    }
}
