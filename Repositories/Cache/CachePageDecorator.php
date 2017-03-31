<?php

namespace Modules\Page\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Page\Repositories\PageRepository;

class CachePageDecorator extends BaseCacheDecorator implements PageRepository
{
    /**
     * @var PageRepository
     */
    protected $repository;

    public function __construct(PageRepository $page)
    {
        parent::__construct();
        $this->entityName = 'pages';
        $this->repository = $page;
    }

    /**
     * Find the page set as homepage
     *
     * @return object
     */
    public function findHomepage()
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findHomepage", $this->cacheTime,
                function () {
                    return $this->repository->findHomepage();
                }
            );
    }

    /**
     * Count all records
     * @return int
     */
    public function countAll()
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.countAll", $this->cacheTime,
                function () {
                    return $this->repository->countAll();
                }
            );
    }

    /**
     * @param $slug
     * @param $locale
     * @return object
     */
    public function findBySlugInLocale($slug, $locale)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findBySlugInLocale.{$slug}.{$locale}", $this->cacheTime,
                function () use ($slug, $locale) {
                    return $this->repository->findBySlugInLocale($slug, $locale);
                }
            );
    }

    /**
     * @param $id
     * @param $locale
     * @return object
     */
    public function findByIdInLocales($id)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findByIdInLocales.{$id}", $this->cacheTime,
                function () use ($id) {
                    return $this->repository->findByIdInLocales($id);
                }
            );
    }

    public function pageLists()
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.pageLists", $this->cacheTime,
                function () {
                    return $this->repository->pageLists();
                }
            );
    }

    public function allRootsForPage()
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.allRootsForPage", $this->cacheTime,
                function () {
                    return $this->repository->allRootsForPage();
                }
            );
    }

    public function getRootForPage($pageId)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.getRootForPage.{$pageId}", $this->cacheTime,
                function () use ($pageId) {
                    return $this->repository->getRootForPage($pageId);
                }
            );
    }

    public function getTreeForPage($pageId)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.getTreeForPage.{$pageId}", $this->cacheTime,
                function () use ($pageId) {
                    return $this->repository->getTreeForPage($pageId);
                }
            );
    }

    public function rootsForPage($pageId)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.rootsForPage.{$pageId}", $this->cacheTime,
                function () use ($pageId) {
                    return $this->repository->rootsForPage($pageId);
                }
            );
    }

    /**
     * Count all records
     * @return int
     */
    public function allForSelect($currentPage='')
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.allForSelect.{$currentPage}", $this->cacheTime,
                function () use ($currentPage) {
                    return $this->repository->allForSelect($currentPage);
                }
            );
    }

    /**
     * @param $slug
     * @param $locale
     * @return mixed
     */
    public function findByUriInLocale($uri, $locale)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findByUriInLocale.{$uri}.{$locale}", $this->cacheTime,
                function () use ($uri, $locale) {
                    return $this->repository->findBySlugInLocale($uri, $locale);
                }
            );
    }

    /**
     * @param $tag
     * @return mixed
     */
    public function findByTag($tag)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findByTag.{$tag}", $this->cacheTime,
                function () use ($tag) {
                    return $this->repository->findByTag($tag);
                }
            );
    }
}
