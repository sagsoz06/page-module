<?php namespace Modules\Page\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Media\Events\Handlers\HandleMediaStorage;
use Modules\Media\Events\Handlers\RemovePolymorphicLink;
use Modules\Page\Events\PageWasCreated;
use Modules\Page\Events\PageWasDeleted;
use Modules\Page\Events\PageWasUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PageWasCreated::class => [
            HandleMediaStorage::class
        ],
        PageWasUpdated::class => [
            HandleMediaStorage::class
        ],
        PageWasDeleted::class => [
            RemovePolymorphicLink::class
        ]
    ];
}