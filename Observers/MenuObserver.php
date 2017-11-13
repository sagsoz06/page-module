<?php namespace Modules\Page\Observers;

use Modules\Menu\Entities\Menu;
use Modules\Page\Entities\Page;
use Modules\Menu\Entities\Menuitem;

class MenuObserver
{
    public function deleted(Page $model)
    {
        if($menuItems = Menuitem::where('page_id', $model->id)->get()) {
            foreach($menuItems as $menuItem) {
                $menuItem->delete();
            }
        }
    }

    public function updated(Page $model) {
        event('page.updateMenuUri', [$model]);

        if($menus = \Request::input('menu')) {
            //Sayfa Menüleri getir
            $pageMenus = $this->getMenusForPage($model);
            //Menülerde yoksa sil
            foreach ($pageMenus as $pageMenu) {
                if(!in_array($pageMenu->menu_id, $menus)) {
                    $pageMenu->delete();
                }
            }
            //Menüde yoksa ekle
            foreach ($menus as $menu) {
                if(!$this->hasMenu($menu, $model)) {
                    $this->createMenu($menu, $model);
                }
            }
        } else {
            //Menü tamamen boşsa sil
            $this->deleted($model);
        }
    }

    public function created(Page $model)
    {
        if($menus = \Request::input('menu')) {
            foreach ($menus as $menu) {
                $this->createMenu($menu, $model);
            }
        }
    }

    private function createMenu($menuId, $model)
    {
        if(!$this->hasMenu($menuId, $model)) {
            $menuItem = new Menuitem();
            $menuItem->menu_id = $menuId;
            $menuItem->page_id = $model->id;
            $menuItem->position = $this->getPositionFormMenu($menuId);
            $menuItem->target = '_self';
            $menuItem->link_type = 'page';
            $menuItem->parent_id = $this->getMenuRoot($menuId);
            $menuItem->is_root = 0;
            foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
                $uri = '';
                if($model->parent) {
                    $uri = $model->parent->translate($locale)->uri . '/';
                }
                $menuItem->translateOrNew($locale)->locale = $locale;
                $menuItem->translateOrNew($locale)->status = 1;
                $menuItem->translateOrNew($locale)->title = $model->translate($locale)->title;
                $menuItem->translateOrNew($locale)->uri = $uri . $model->translate($locale)->slug;
            }

            $menuItem->save();
        }
    }

    private function getMenusForPage(Page $page)
    {
        return MenuItem::where('page_id', $page->id)->get();
    }

    private function getPositionFormMenu($id)
    {
        $position = Menuitem::where('menu_id', $id)->max('position');
        return $position + 1;
    }

    private function hasMenu($menuId, $model)
    {
        return Menuitem::where('page_id', $model->id)->where('menu_id', $menuId)->count() > 0;
    }

    private function getMenu($menuId, $model) {
        return Menuitem::where('page_id', $model->id)->where('menu_id', $menuId)->first();
    }

    private function getMenuRoot($menuId)
    {
        if($menuItem = Menuitem::where('menu_id', $menuId)->where('is_root', 1)->first()){
            return $menuItem->id;
        }
        return null;
    }
}