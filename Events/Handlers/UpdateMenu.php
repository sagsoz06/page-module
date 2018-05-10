<?php namespace Modules\Page\Events\Handlers;

use Illuminate\Events\Dispatcher;
use Modules\Menu\Entities\Menuitem;
use Modules\Page\Entities\Page;

class UpdateMenu
{
    public function updateMenuUri(Page $page)
    {
        if($menuItems = Menuitem::where('page_id', $page->id)->get()) {
            foreach ($menuItems as $menuItem) {
                foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
                    if($menuItem->hasTranslation($locale)) {
                        $menuItem->translate($locale)->uri = $page->translate($locale)->slug;
                        if(isset($page->settings->update_menu)) {
                            $menuItem->translate($locale)->title = $page->translate($locale)->title;
                        }
                        $menuItem->translate($locale)->status = $page->translate($locale)->status;
                    }
                }
                $menuItem->save();
            }
        }
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen('page.updateMenuUri', 'Modules\Page\Events\Handlers\UpdateMenu@updateMenuUri');
    }
}