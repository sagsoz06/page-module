<?php namespace Modules\Page\Widgets;


use Modules\Page\Entities\Page;
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
        if($page = $this->page->findBySlug($slug)) {
            return view('page::widgets.'.$view, compact('page'));
        }
        return null;
    }

    public function findById($id = '', $view = 'find-page')
    {
        if($page = $this->page->find($id)) {
            return view('page::widgets.'.$view, compact('page'));
        }
        return null;
    }

    public function findBySlugChildren($slug, $view='children', $limit=10)
    {
        if($page = $this->page->findBySlug($slug)) {
            $children = $page->children()->orderBy('position', 'ASC')->limit($limit)->get();
            return view('page::widgets.'.$view, compact('children', 'page'));
        }
        return null;
    }

    public function getChildrenByPage(Page $page, $view='children', $limit=10, $paginate=10)
    {
        if($page->children()->count()>0) {
            $children = $page->children()->orderBy('position', 'ASC')->limit($limit)->paginate($paginate);
            return view('page::widgets.'.$view, compact('children', 'page'));
        }
        return null;
    }

    public function findByOptions($option='', $view='page-slider')
    {
        $pages = $this->page->all()->where($option, 1);
        return view('page::widgets.'.$view, compact('pages'));
    }

    public function tags(Page $page, $limit=5, $view='tags')
    {
        if($page->tags->count()>0) {
            $tags = $page->tags()->take($limit)->get();
            return view('page::widgets.'.$view, compact('tags'));
        }
        return null;
    }

    public function parentMenu(Page $page, $view='parent-menu', $limit=30)
    {
        if($page->children()->count()>0) {
            $page->load('children');
            $children = $page->children()->get()->sortBy('position')->take($limit);
            $page = $page->parent()->first();
            return view('page::widgets.'.$view, compact('children', 'page'));
        } else {
            $children = $page->parent->children()->get()->sortBy('position')->take($limit);
            return view('page::widgets.'.$view, compact('children', 'page'));
        }
        return null;
    }
}
