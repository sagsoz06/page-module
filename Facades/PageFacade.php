<?php namespace Modules\Page\Facades;


use Illuminate\Support\Facades\Facade;
use Modules\Page\Repositories\PageRepository;

class PageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PageRepository::class;
    }
}