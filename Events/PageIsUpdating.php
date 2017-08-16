<?php

namespace Modules\Page\Events;

use Modules\Core\Events\AbstractEntityHook;
use Modules\Core\Contracts\EntityIsChanging;
use Modules\Page\Entities\Page;

class PageIsUpdating extends AbstractEntityHook implements EntityIsChanging
{
    private $page;

    public function __construct(Page $page, array $attributes)
    {
        $this->page = $page;
        parent::__construct($attributes);
    }
}
