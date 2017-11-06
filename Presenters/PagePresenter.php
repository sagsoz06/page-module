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

    public function subTitles($title=false)
    {
        $pages = collect();
        if(isset($this->entity->parent->parent)) {
            $pages->push($this->entity->parent->parent);
        }
        if(isset($this->entity->parent)) {
            $pages->push($this->entity->parent);
        }
        if($title) {
            $pages->push($this->entity);
        }
        return $pages->pluck('title')->implode(' / ');
    }

    public function coverImage($width, $height, $mode, $quality)
    {
        if($file = $this->entity->files()->where('zone', 'pageCover')->first()) {
            return \Imagy::getImage($file->filename, $this->zone, ['width' => $width, 'height' => $height, 'mode' => $mode, 'quality' => $quality]);
        }
        return false;
    }
}