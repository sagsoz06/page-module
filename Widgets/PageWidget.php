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

    public function findBySlug($slug='', $view='find-page')
    {
        if($page = $this->page->findBySlug($slug))
        return view('page::widgets.'.$view, compact('page'));
    }

    public function findBySlugChildren($slug = '', $view='children', $limit=10)
    {
        if($page = $this->page->findBySlug($slug)) {
            $children = $page->children()->orderBy('position', 'ASC')->limit($limit)->get();
            return view('page::widgets.'.$view, compact('children', 'page'));
        }
    }

    public function findByOptions($option='', $view='page-slider')
    {
        $pages = $this->page->all()->where($option, 1);
        return view('page::widgets.'.$view, compact('pages'));
    }
}