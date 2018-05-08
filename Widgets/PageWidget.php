<?php namespace Modules\Page\Widgets;


use Modules\Page\Repositories\PageRepository;

class PageWidget
{
    /**
     * @var PageRepository
     */
    private $page;

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }

    public function findPage($slug='', $view='find-page')
    {
        if($page = $this->page->findBySlug($slug)) {
            return view('page::widgets.'.$view, compact('page'))->render();
        }
        return false;
    }

    public function children($slug = '', $view='children', $limit=10)
    {
        if($page = $this->page->findBySlug($slug))
        {
            if(isset($page->children)) {
                $children = $page->children()->orderBy('position', 'ASC')->limit($limit)->get();
                return view('page::widgets.'.$view, compact('children', 'page'))->render();
            }
        }
        return false;
    }
}