<?php namespace Modules\Page\Services;

use Modules\Menu\Entities\Menuitem;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\UpdatePageRequest;

class PageMenu
{
    public function checkMenu(UpdatePageRequest $request, Page $page)
    {
        if($menus = $request->input('menu')) {
            $pageMenus = $this->getMenusForPage($page);
            foreach ($pageMenus as $pageMenu) {
                if(!in_array($pageMenu->menu_id, $menus)) {
                    $pageMenu->delete();
                }
            }
            foreach ($menus as $menu) {
                if(!$this->hasMenu($menu, $page)) {
                    $this->createMenu($menu, $page);
                }
            }
        } else {
            $this->deleteMenu($page);
        }
    }

    public function deleteMenu(Page $page)
    {
        if($menuItems = Menuitem::where('page_id', $page->id)->get()) {
            foreach($menuItems as $menuItem) {
                $menuItem->delete();
            }
        }
    }

    public function createMenu($menuId, Page $page)
    {
        if(!$this->hasMenu($menuId, $page)) {
            $menuItem = new Menuitem();
            $menuItem->menu_id      = $menuId;
            $menuItem->page_id      = $page->id;
            $menuItem->position     = $this->getPositionFormMenu($menuId);
            $menuItem->target       = '_self';
            $menuItem->link_type    = 'page';
            $menuItem->parent_id    = $this->getParentId($menuId, $page);
            $menuItem->is_root      = 0;
            foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
                $menuItem->translateOrNew($locale)->locale  = $locale;
                $menuItem->translateOrNew($locale)->status  = 1;
                $menuItem->translateOrNew($locale)->title   = $page->translate($locale)->title;
                $menuItem->translateOrNew($locale)->uri     = $page->translate($locale)->slug;
            }
            $menuItem->save();
        }
    }

    private function getPositionFormMenu($id)
    {
        $position = Menuitem::where('menu_id', $id)->max('position');
        return $position + 1;
    }

    private function getParentId($menuId, Page $page)
    {
        if($id = $this->getParentMenuId($menuId, $page)) {
            return $id;
        }
        if($menuItem = Menuitem::where('menu_id', $menuId)->where('is_root', 1)->first()){
            return $menuItem->id;
        }
        return null;
    }

    private function getParentMenuId($menuId, Page $page)
    {
        if($page->parent()->count()>0) {
            if($this->hasMenu($menuId, $page->parent)) {
                $menuItem = $this->getMenu($menuId, $page->parent);
                return $menuItem->id;
            }
        }
        return false;
    }

    private function getMenusForPage(Page $page)
    {
        return MenuItem::where('page_id', $page->id)->get();
    }

    private function getMenu($menuId, $page) {
        return Menuitem::where('page_id', $page->id)->where('menu_id', $menuId)->first();
    }

    private function hasMenu($menuId, $page)
    {
        return Menuitem::where('page_id', $page->id)->where('menu_id', $menuId)->count() > 0;
    }
}