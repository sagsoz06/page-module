<?php

namespace Modules\Page\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface PageRepository extends BaseRepository
{
    /**
     * Find the page set as homepage
     * @return object
     */
    public function findHomepage();

    /**
     * Count all records
     * @return int
     */
    public function countAll();

    /**
     * @param $slug
     * @param $locale
     * @return object
     */
    public function findBySlugInLocale($slug, $locale);

    /**
     * @param $id
     * @param $locale
     * @return object
     */
    public function findByIdInLocales($id);

    /**
     * @return mixed
     */
    public function pageLists();

    /**
     * @return mixed
     */
    public function allRootsForPage();

    /**
     * @param $pageId
     * @return mixed
     */
    public function getRootForPage($pageId);

    /**
     * @param $pageId
     * @return mixed
     */
    public function getTreeForPage($pageId);

    /**
     * @param $pageId
     * @return mixed
     */
    public function rootsForPage($pageId);

    /**
     * @return mixed
     */
    public function allForSelect($currentPage);

    /**
     * @param $tag
     * @return mixed
     */
    public function findByTag($tag);

    /**
     * @param $setting
     * @param $value
     * @return mixed
     */
    public function findInSettings($setting, $value);
}
