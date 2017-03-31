<?php namespace Modules\Page\Services;

use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageRepository;

class PageOrdener
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param $data
     */
    public function handle($data)
    {
        $data = $this->convertToArray(json_decode($data));

        foreach ($data as $position => $item) {
            $this->order($position, $item);
        }
    }

    /**
     * Order recursively the menu items
     * @param int   $position
     * @param array $item
     */
    private function order($position, $item)
    {
        $page = $this->pageRepository->find($item['id']);
        $this->savePosition($page, $position);
        $this->makeItemChildOf($page, null);

        if ($this->hasChildren($item)) {
            $this->handleChildrenForParent($page, $item['children']);
            event('page.resetChildrenUri', [$page]);
        }
        event('page.updateMenuUri', [$page]);
    }

    /**
     * @param Page $parent
     * @param array    $children
     */
    private function handleChildrenForParent(Page $parent, array $children)
    {
        foreach ($children as $position => $item) {
            $page = $this->pageRepository->find($item['id']);
            $this->savePosition($page, $position);
            $this->makeItemChildOf($page, $parent->id);

            if ($this->hasChildren($item)) {
                $this->handleChildrenForParent($page, $item['children']);
            }
        }
    }

    /**
     * Save the given position on the menu item
     * @param object $menuItem
     * @param int    $position
     */
    private function savePosition($item, $position)
    {
        $this->pageRepository->update($item, compact('position'));
    }

    /**
     * Check if the item has children
     *
     * @param  array $item
     * @return bool
     */
    private function hasChildren($item)
    {
        return isset($item['children']);
    }

    /**
     * Set the given parent id on the given menu item
     *
     * @param object $item
     * @param int    $parent_id
     */
    private function makeItemChildOf($item, $parent_id)
    {
        $this->pageRepository->update($item, compact('parent_id'));
    }

    /**
     * Convert the object to array
     * @param $data
     * @return array
     */
    private function convertToArray($data)
    {
        $data = json_decode(json_encode($data), true);

        return $data;
    }
}