<?php

namespace Modules\Page\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Page\Exceptions\ApiNotFoundException;
use Modules\Page\Repositories\PageRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PublicController extends Controller
{
    /**
     * @var PageRepository
     */
    private $page;

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }

    public function get(Request $request)
    {
        try {
            if($request->ajax()) {
                if($request->has('page_id')) {
                    return response()->json(['success'=>true, 'data'=>$this->page->find($request->page_id)]);
                } else {
                    throw new ApiNotFoundException('Sayfa seçilmedi');
                }
            } else {
                throw new BadRequestHttpException("Hatalı İstek");
            }
        } catch (ApiNotFoundException $exception) {
            return response()->json(['error'=>true, 'message'=>$exception->getMessage()]);
        } catch (BadRequestHttpException $exception) {
            return response()->json(['error'=>true, 'message'=>$exception->getMessage()]);
        }
    }
}
