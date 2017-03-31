<?php namespace Modules\Page\Presenters;

use Modules\Core\Presenters\BasePresenter;

class PagePresenter extends BasePresenter
{
    protected $zone = 'pageImage';
    protected $slug = '';
    protected $transKey = 'page';
    protected $routeKey = '';
    protected $slugKey = 'uri';
    protected $titleKey = 'title';
    protected $descriptionKey = 'body';

    public function parentUri($lang)
    {
        $parentUri = '/';
        if ($this->entity->hasTranslation($lang)) {
            $parentUri = $this->entity->translate($lang)->uri;
        }
        $parentUri = explode('/', $parentUri);
        array_pop($parentUri);
        $parentUri = implode('/', $parentUri).'/';

        return $parentUri;
    }
}