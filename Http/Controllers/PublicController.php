<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageRepository;
use Breadcrumbs;
use Modules\Tag\Repositories\TagRepository;

class PublicController extends BasePublicController
{
    /**
     * @var PageRepository
     */
    private $page;
    /**
     * @var Application
     */
    private $app;
    /**
     * @var TagRepository
     */
    private $tag;

    public function __construct(PageRepository $page, Application $app, TagRepository $tag)
    {
        parent::__construct();
        $this->page = $page;
        $this->app = $app;
        $this->tag = $tag;
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function uri($slug)
    {
        $page = $this->findPageForSlug($slug);

        $this->throw404IfNotFound($page);

        $template = $this->getTemplateForPage($page);

        /* Start Seo */
        $this->seo()
            ->setTitle($page->present()->meta_title)
            ->setDescription($page->present()->meta_description)
            ->setKeywords($page->present()->keywords)
            ->meta()
            ->setUrl($page->url)
            ->addMeta('robots', $page->robots)
            ->addAlternates($page->present()->languages);

        $this->seoGraph()
            ->setTitle($page->present()->og_title)
            ->setDescription($page->present()->og_description)
            ->setType($page->og_type)
            ->setImage($page->present()->og_image)
            ->setUrl($page->url);

        $this->seoCard()
            ->setTitle($page->present()->og_title)
            ->setDescription($page->present()->og_description)
            ->addImage($page->present()->og_image)
            ->setType('app');
        /* End Seo */

        /* Start Breadcrumbs */
        Breadcrumbs::register('page', function ($breadcrumbs) use ($page) {
            $this->_parentBreadcrumbs($breadcrumbs, $page);
            $breadcrumbs->push($page->title, $page->url);
        });
        /* End Breadcrumbs */

        return view($template, compact('page'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function homepage()
    {
        $page = $this->page->findHomepage();

        $this->throw404IfNotFound($page);

        $template = $this->getTemplateForPage($page);

        /* Start Seo */
        $this->seo()
            ->setTitle($page->present()->meta_title)
            ->setDescription($page->present()->meta_description)
            ->setSiteName('')
            ->meta()
            ->setUrl($page->url)
            ->addMeta('robots', $page->robots)
            ->addAlternates($page->present()->languages);

        $this->seoGraph()
            ->setTitle($page->present()->og_title)
            ->setDescription($page->present()->og_description)
            ->setType($page->og_type)
            ->setUrl($page->url);

        $this->seoCard()
            ->setTitle($page->present()->og_title)
            ->setDescription($page->present()->og_description)
            ->setType('app');
        /* End Seo */

        return view($template, compact('page'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($slug)
    {
        $tag = $this->tag->findBySlug($slug);

        $this->throw404IfNotFound($tag);

        $pages = $this->page->findByTag($slug);

        /* Start Seo */
        $title = trans('themes::tags.tag', ['tag'=>$tag->name]);
        $this->seo()->setTitle($title)
            ->setDescription($tag->name)
            ->meta()->setUrl(route('page.tag', [$tag->slug]))
            ->addMeta('robots', "index, follow");
        /* End Seo */

        /* Start Breadcrumbs */
        Breadcrumbs::register('page.tag', function ($breadcrumbs) use ($tag) {
            $breadcrumbs->push(trans('tag::tags.tag') . ' : ' . $tag->name, $tag->url);
        });
        /* End Breadcrumbs */

        return view('page::tag', compact('pages', 'tag'));
    }

    /**
     * Find a page for the given slug.
     * The slug can be a 'composed' slug via the Menu
     * @param string $slug
     * @return Page
     */
    private function findPageForSlug($slug)
    {
//        $menuItem = app(MenuItemRepository::class)->findByUriInLanguage($slug, locale());
//
//        if ($menuItem) {
//            return $this->page->find($menuItem->page_id);
//        }

        return $this->page->findByUriInLocale($slug, locale());
    }

    /**
     * Return the template for the given page
     * or the default template if none found
     * @param $page
     * @return string
     */
    private function getTemplateForPage($page)
    {
        return (view()->exists($page->template)) ? $page->template : 'default';
    }

    /**
     * Throw a 404 error page if the given page is not found
     * @param $page
     */
    private function throw404IfNotFound($page)
    {
        if (is_null($page)) {
            $this->app->abort('404');
        }
    }

    private function _parentBreadcrumbs($breadcrumbs, $page)
    {
        if (isset($page->parent)) {
            $this->_parentBreadcrumbs($breadcrumbs, $page->parent);
        }
        if (isset($page->parent)) {
            $breadcrumbs->push($page->parent->title, $page->parent->url);
        }
    }

    public function intro()
    {
        $page = $this->page->findBySlug('intro');

        $this->throw404IfNotFound($page);

        $template = $this->getTemplateForPage($page);

        /* Start Seo */
        $this->seo()
            ->setTitle($page->present()->meta_title)
            ->setDescription($page->present()->meta_description)
            ->meta()
            ->setUrl($page->url)
            ->addMeta('robots', $page->robots)
            ->addAlternates($page->present()->languages);

        $this->seoGraph()
            ->setTitle($page->present()->og_title)
            ->setDescription($page->present()->og_description)
            ->setType($page->og_type)
            ->setUrl($page->url);

        $this->seoCard()
            ->setTitle($page->present()->og_title)
            ->setDescription($page->present()->og_description)
            ->setType('app');
        /* End Seo */

        return view($template, compact('page'));
    }
}
