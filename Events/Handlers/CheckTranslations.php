<?php namespace Modules\Page\Events\Handlers;

use Illuminate\Events\Dispatcher;
use Modules\Menu\Entities\Menuitem;
use Modules\Page\Entities\Page;

class CheckTranslations
{
    public function checkTranslationPages()
    {
        $pages = Page::all();

        foreach ($pages as $page) {
            foreach ($page->translations as $translation) {
                if(!array_key_exists($translation->locale, \LaravelLocalization::getSupportedLocales())) {
                    $translation->delete();
                }
            }
        }

        $menuItems = Menuitem::all();
        foreach ($menuItems as $menuItem) {
            foreach ($menuItem->translations as $translation) {
                if(!array_key_exists($translation->locale, \LaravelLocalization::getSupportedLocales())) {
                    $translation->delete();
                }
            }
        }
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen('page.checkTranslationPages', 'Modules\Page\Events\Handlers\CheckTranslations@checkTranslationPages');
    }
}