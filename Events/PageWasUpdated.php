<?php

namespace Modules\Page\Events;

use Modules\Media\Contracts\StoringMedia;
use Modules\Page\Entities\Page;

class PageWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var int
     */
    public $pageId;
    public $page;

    public function __construct($pageId, array $data, Page $page)
    {
        $this->data = $data;
        $this->pageId = $pageId;
        $this->page = $page;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->page;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
