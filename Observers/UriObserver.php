<?php namespace Modules\Page\Observers;

use Modules\Page\Entities\PageTranslation;

class UriObserver
{
    public function creating(PageTranslation $model)
    {
        $model->slug = $this->incrementWhileExists($model, $model->slug);
    }

    public function updating(PageTranslation $model)
    {
        $model->slug = $this->incrementWhileExists($model, $model->slug, $model->id);
    }

    /**
     * @param PageTranslation $model
     * @param $uri
     * @param $id
     * @return bool
     */
    private function uriExists(PageTranslation $model, $uri, $id)
    {
        $query = $model->where('slug', $uri)
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