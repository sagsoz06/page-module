<?php

namespace Modules\Page\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Page\Repositories\PageRepository;
use Modules\User\Contracts\Authentication;

class PermissionMiddleware
{
    /**
     * @var Authentication
     */
    private $auth;
    /**
     * @var PageRepository
     */
    private $page;

    public function __construct(Authentication $auth, PageRepository $page)
    {
        $this->auth = $auth;
        $this->page = $page;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($slug = $request->route()->parameter('uri')) {
            if($page = $this->page->findBySlugInLocale($slug, locale())) {
                if(is_array($page->permissions)) {
                    if($this->auth->check()) {
                        if($this->auth->user()->roles()->whereIn('id', $page->permissions)->count()>0 || $this->auth->user()->hasRoleSlug('admin')) {
                            return $next($request);
                        } else {
                            return redirect()->back()->withError(trans('page::messages.permission denied'));
                        }
                    } else {
                        return redirect()->guest(route('login'))->withError(trans('hr::applications.messages.user login required'));
                    }
                }
            }
        }
        return $next($request);
    }
}
