<?php namespace Modules\Page\Observers;

use Modules\Menu\Entities\Menu;
use Modules\Page\Entities\Page;
use Modules\Menu\Entities\Menuitem;
use Modules\Page\Services\PageMenu;

class MenuObserver
{
    /**
     * @var PageMenu
     */
    private $pageMenu;

    public function __construct(PageMenu $pageMenu)
    {
        $this->pageMenu = $pageMenu;
    }

    public function deleted(Page $model)
    {
        $this->pageMenu->deleteMenu($model);
        event('menu.clearCache');
    }

    public function updated(Page $model) {
        event('page.updateMenuUri', [$model]);
        event('menu.clearCache');
    }

    public function created(Page $model)
    {
        if($menus = \Request::input('menu')) {
            foreach ($menus as $menu) {
                $this->pageMenu->createMenu($menu, $model);
            }
        }
        event('menu.clearCache');
    }
}