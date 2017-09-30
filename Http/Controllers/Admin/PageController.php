<?php

namespace Modules\Page\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Media\Repositories\FileRepository;
use Modules\Menu\Repositories\MenuRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\CreatePageRequest;
use Modules\Page\Http\Requests\UpdatePageRequest;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Services\PageRenderer;

class PageController extends AdminBaseController
{
    /**
     * @var PageRepository
     */
    private $page;

    private $file;

    private $pageRenderer;
    /**
     * @var MenuRepository
     */
    private $menu;

    public function __construct(
        PageRepository $page,
        PageRenderer $pageRenderer,
        MenuRepository $menu,
        FileRepository $file
    )
    {
        parent::__construct();

        $this->page = $page;
        $this->file = $file;
        $this->pageRenderer = $pageRenderer;
        $this->menu = $menu;

        $menuLists = $this->menu->menuList();

        view()->share('menuLists', $menuLists);

    }

    public function index()
    {
        $pages = $this->page->allRootsForPage();

        $pageStructure = $this->pageRenderer->renderForMenu($pages->nest());

        return view('page::admin.index', compact('pages', 'pageStructure'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $selectPages = $this->page->allForSelect('');

        return view('page::admin.create', compact('selectPages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePageRequest $request
     * @return Response
     */
    public function store(CreatePageRequest $request)
    {
        $this->page->create($request->all());

        return redirect()->route('admin.page.page.index')
            ->withSuccess(trans('page::messages.page created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @return Response
     */
    public function edit(Page $page)
    {
        $selectedMenus = $this->menu->all()->keyBy('id')->filter(function($menu) use ($page) {
           return $menu->menuitems()->where('page_id', $page->id)->where('link_type', 'page')->first();
        })->keys()->toArray();

        $selectPages = $this->page->allForSelect($page->id);

        return view('page::admin.edit', compact('page', 'selectPages', 'selectedMenus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Page $page
     * @param  UpdatePageRequest $request
     * @return Response
     */
    public function update(Page $page, UpdatePageRequest $request)
    {
        $this->page->update($page, $request->all());

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.page.page.index')
                ->withSuccess(trans('page::messages.page updated'));
        }

        return redirect()->back()
            ->withSuccess(trans('page::messages.page updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return Response
     */
    public function destroy(Page $page)
    {
        $this->page->destroy($page);

        return redirect()->route('admin.page.page.index')
            ->withSuccess(trans('page::messages.page deleted'));
    }
}