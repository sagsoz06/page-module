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
        $this->sitemap->setCache('laravel.page.sitemap', $this->sitemapCachePeriod);
    }

    public function index()
    {
        foreach ($this->page->allTranslatedIn(locale()) as $page)
        {
            if(!$page->sitemap_include) continue;

            $images = [];
            if(isset($page->thumbnail))
            {
                $images[] = ['url' => $page->thumbnail, 'title' => $page->title];
            }
            $this->sitemap->add(
                $page->url,
                $page->updated_at,
                $page->sitemap_priority,
                $page->sitemap_frequency,
                $images,
                null,
                $page->present()->languages('language')
            );
        }
        return $this->sitemap->render('xml');
    }
}
