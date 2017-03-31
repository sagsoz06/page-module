<?php namespace Modules\Page\Widgets;

use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Modules\Page\Repositories\PageRepository;

class LatestPageWidget extends BaseWidget
{
    private $page;

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }

    protected function name()
    {
        return 'LatestPageWidget';
    }

    protected function options()
    {
        return [
            'width' => '2',
            'height' => '2',
            'x' => '4'
        ];
    }

    protected function view()
    {
        return 'page::admin.widgets.pages';
    }

    protected function data()
    {
        return ['pages' => $this->page->countAll()];
    }

}