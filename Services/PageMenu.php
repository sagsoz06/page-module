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
            $menuItem->parent_id    = $this->getMenuRoot($menuId);
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

    private function getMenuRoot($menuId)
    {
        if($menuItem = Menuitem::where('menu_id', $menuId)->where('is_root', 1)->first()){
            return $menuItem->id;
        }
        return null;
    }

    private function getMenusForPage(Page $page)
    {
        return MenuItem::where('page_id', $page->id)->get();
    }

    private function getMenu($menuId, $model) {
        return Menuitem::where('page_id', $model->id)->where('menu_id', $menuId)->first();
    }

    private function hasMenu($menuId, $model)
    {
        return Menuitem::where('page_id', $model->id)->where('menu_id', $menuId)->count() > 0;
    }
}