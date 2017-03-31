<?php namespace Modules\Page\Events\Handlers;


use Illuminate\Events\Dispatcher;
use Modules\Menu\Entities\Menuitem;
use Modules\Page\Entities\Page;

class UpdateMenu
{
    public function updateMenuUri(Page $model)
    {
        if($menuItems = Menuitem::where('page_id', $model->id)->get()) {
            foreach ($menuItems as $menuItem) {
                foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
                    if($menuItem->hasTranslation($locale)) {
                        $menuItem->translate($locale)->uri = $model->translate($locale)->uri;
                        $menuItem->translate($locale)->title = $model->translate($locale)->title;
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