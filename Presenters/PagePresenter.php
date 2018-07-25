<?php namespace Modules\Page\Presenters;

use Modules\Core\Presenters\BasePresenter;
use Modules\Page\Entities\Page;

class PagePresenter extends BasePresenter
{
    protected $zone = 'pageImage';
    protected $slug = '';
    protected $transKey = 'page';
    protected $routeKey = '';
    protected $slugKey = 'slug';
    protected $titleKey = 'title';
    protected $descriptionKey = 'body';

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->parents = collect();
    }

    public function parentSlug()
    {
        return $this->_getParentAll($this->entity)->reverse()->map(function($page){
            return $page->slug;
        })->implode('/');
    }

    private function _getParentAll(Page $page, $current=false)
    {
        if($page->parent()->exists()) {
            $this->parents->push($page->parent);
            return $this->_getParentAll($page->parent);
        } else {
            if($current) {
                $this->parents->push($page);
            }
            return $this->parents;
        }
    }

    public function subTitles($title=false)
    {
        return $this->_getParentAll($this->entity, $title)->map(function($page){
            return $page->title;
        })->implode(' / ');
    }

    public function coverImage($width, $height, $mode, $quality)
    {
        if($file = $this->entity->files()->where('zone', 'pageCover')->first()) {
            return \Imagy::getImage($file->filename, $this->zone, ['width' => $width, 'height' => $height, 'mode' => $mode, 'quality' => $quality]);
        }
        return false;
    }

    public function languages($langKey = 'lang', $urlKey = 'url', $sitemap = false)
    {
        $languages = collect();
        foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale)
        {
            if($this->entity->hasTranslation($locale)) {
                $languages->push([$langKey => $locale, $urlKey => $this->entity->is_home ? \LaravelLocalization::getLocalizedURL($locale, route('homepage')) : $this->url($locale)]);
            }
        }
        return $languages->toArray();
    }

    public function files()
    {
        if($files = $this->entity->files()->where('zone', 'pageFiles')->get()) {
            return $files;
        }
        return '';
    }
}