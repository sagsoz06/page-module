<?php

namespace Modules\Page\Http\Controllers;

use Modules\Page\Repositories\PageRepository;
use Modules\Sitemap\Http\Controllers\BaseSitemapController;

class SitemapController extends BaseSitemapController
{
    /**
     * @var PageRepository
     */
    private $page;

    public function __construct(PageRepository $page)
    {
        parent::__construct();
        $this->page = $page;
    }

    public function index()
    {
        foreach ($this->page->allTranslatedIn(locale()) as $page)
        {
            if(!$page->sitemap_include) continue;

            $images = [];
            if($page->hasImage())
            {
                $images[] = ['url' => url($page->present()->firstImage(500,null,'resize',80)), 'title' => $page->title];
            }
            $this->sitemap->add(
                $page->is_home ? \LaravelLocalization::getLocalizedURL(locale(), route('homepage')) : $page->url,
                $page->updated_at,
                $page->sitemap_priority,
                $page->sitemap_frequency,
                $images,
                null,
                $page->present()->languages('language', 'url', true)
            );
        }
        return $this->sitemap->render('xml');
    }
}
