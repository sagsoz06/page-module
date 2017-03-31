<?php namespace Modules\Page\Events\Handlers;

use Illuminate\Events\Dispatcher;
use Modules\Page\Entities\Page;

class UpdateChildren
{
    public function updateChildrenUri(Page $model) {

        if(isset($model->children)) {
            foreach ($model->children as $child) {
                foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
                    if($child->hasTranslation($locale)) {
                        $child->translate($locale)->uri = $model->translate($locale)->uri . '/' . $child->translate($locale)->slug;
                    }
                }
                $child->save();
                if(isset($child->children)) {
                    $this->updateChildrenUri($child);
                }
            }
        }
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen('page.updateChildrenUri', 'Modules\Page\Events\Handlers\UpdateChildren@updateChildrenUri');
    }
}