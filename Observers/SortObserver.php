<?php namespace Modules\Page\Observers;

use Modules\Page\Entities\Page;


class SortObserver
{
    public function creating(Page $model)
    {
        $model->position = Page::count() + 1;
    }
    public function updating(Page $model)
    {
        if ($model->isDirty('parent_id')) {
            foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
                $model->translate($locale)->uri = '';
            }
        }
    }
}