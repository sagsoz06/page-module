<?php namespace Modules\Page\Events\Handlers;

use Illuminate\Events\Dispatcher;
use Modules\Page\Entities\Page;

class ResetChildren
{
    public function resetChildrenUri(Page $page)
    {
        foreach ($page->children as $childPage)
        {
            foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
                if(is_null($page->translate($locale)->uri)){
                    $childPage->translate($locale)->uri = null;
                } else {
                    $childPage->translate($locale)->uri = '';
                }
            }
            $childPage->save();
            $this->resetChildrenUri($childPage);
        }
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen('page.resetChildrenUri', 'Modules\Page\Events\Handlers\ResetChildren@resetChildrenUri');
    }
}