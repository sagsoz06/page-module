<?php namespace Modules\Page\Observers;

use Modules\Page\Entities\PageTranslation;

class UriObserver
{
    public function creating(PageTranslation $model)
    {
        $parentUri = $this->getParentUri($model);

        if($parentUri) {
            $uri = $parentUri;
            if($model->slug) {
                $uri .= '/'.$model->slug;
            }
        } else {
            $uri = $model->slug;
        }

        $model->uri = $this->incrementWhileExists($model, $uri);
    }

    public function updating(PageTranslation $model)
    {
        $parentUri = $this->getParentUri($model);

        if($parentUri) {
            $uri = $parentUri;
            if($model->slug) {
                $uri .= '/'.$model->slug;
            }
        } else {
            $uri = $model->slug;
        }

        $model->uri = $this->incrementWhileExists($model, $uri, $model->id);
    }

    public function getParentUri(PageTranslation $model)
    {
        if ($parentPage = $model->page->parent) {
            if($parentPage->hasTranslation($model->locale)) {
                return $parentPage->translate($model->locale)->uri;
            }
        }
    }


    /**
     * @param PageTranslation $model
     * @param $uri
     * @param $id
     * @return bool
     */
    private function uriExists(PageTranslation $model, $uri, $id)
    {
        $query = $model->where('uri', $uri)
                       ->where('locale', $model->locale);
        if ($id) {
            $query->where('id', '!=', $id);
        }

        if ($query->first()) {
            return true;
        }

        return false;
    }


    /**
     * @param PageTranslation $model
     * @param $uri
     * @param null $id
     * @return string|void
     */
    private function incrementWhileExists(PageTranslation $model, $uri, $id = null)
    {
        if (!$uri) {
            return;
        }

        $originalUri = $uri;

        $i = 0;
        // Check if uri is unique
        while ($this->uriExists($model, $uri, $id)) {
            $i++;
            // increment uri if it exists
            $uri = $originalUri.'-'.$i;
        }
        return $uri;
    }
}