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
        return $this->_getParentAll($this->entity)->map(function($page){
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
            return $page->slug;
        })->implode(' / ');
    }

    public function coverImage($width, $height, $mode, $quality)
    {
        if($file = $this->entity->files()->where('zone', 'pageCover')->first()) {
            return \Imagy::getImage($file->filename, $this->zone, ['width' => $width, 'height' => $height, 'mode' => $mode, 'quality' => $quality]);
        }
        return false;
    }
}