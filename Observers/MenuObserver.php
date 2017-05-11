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
    }

    public function created(Page $model)
    {
        if($menus = \Request::input('menu')) {
            foreach ($menus as $menu) {
                $this->_creatingMenu($menu, $model);
            }
        }
    }

    private function _creatingMenu($menuId, $model)
    {
        if($this->_existMenu($menuId) && !Menuitem::where('page_id', $model->id)->where('menu_id', $menuId)->first()) {
            $menuItem = new Menuitem();
            $menuItem->menu_id = $menuId;
            $menuItem->page_id = $model->id;
            $menuItem->position = $this->_getPositionFormMenu($menuId);
            $menuItem->target = '_self';
            $menuItem->link_type = 'page';
            $menuItem->parent_id = $this->_getMenuRoot($menuId);
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

    private function _getPositionFormMenu($id)
    {
        $position = Menuitem::where('menu_id', $id)->max('position');
        return $position + 1;
    }

    private function _existMenu($menuId)
    {
        $query = Menu::where('id', $menuId);
        if ($query->first()) {
            return true;
        }
        return false;
    }

    private function _getMenuRoot($menuId)
    {
        if($menuItem = Menuitem::where('menu_id', $menuId)->where('is_root', 1)->first()){
            return $menuItem->id;
        }
        return null;
    }
}