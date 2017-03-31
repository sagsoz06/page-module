<?php namespace Modules\Page\Http\Controllers\Api;

use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Page\Http\Requests\DeletePageRequest;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Services\PageOrdener;

class PageController extends AdminBaseController
{
    private $cache;
    private $page;
    private $pageOrdener;

    public function __construct(PageRepository $page, Repository $cache, PageOrdener $pageOrdener)
    {
        parent::__construct();
        $this->page = $page;
        $this->cache = $cache;
        $this->pageOrdener = $pageOrdener;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('page::index');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
            $this->cache->tags($locale.'.pages')->flush();
        }
        $this->pageOrdener->handle($request->get('page'));
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(DeletePageRequest $request)
    {
        $page = $this->page->find($request->get('pageId'));

        if (! $page) {
            return Response::json(['errors' => true]);
        }

        $this->page->destroy($page);

        return Response::json(['errors' => false]);
    }
}
