<?php  namespace Modules\Page\Widgets;

use Modules\Page\Repositories\PageRepository;

class PageChildrenWidget
{
    private $page;

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }

    public function register($slug = '', $view='')
    {
        if($page = $this->page->findBySlug($slug))
        {
            if(isset($page->children)) {
                $children = $page->children()->orderBy('position', 'ASC')->get();
                if(!empty($view)) {
                    return view('page::widgets.'.$view, compact('children', 'page'))->render();
                } else {
                    return view('page::widgets.children', compact('children', 'page'))->render();
                }
            }
        }
        return false;
    }
}