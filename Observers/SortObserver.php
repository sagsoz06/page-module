<?php namespace Modules\Page\Observers;

use Modules\Page\Entities\Page;


class SortObserver
{
    public function creating(Page $model)
    {
        $model->position = Page::count() + 1;
    }
}