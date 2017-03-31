<?php  namespace Modules\Page\Services;

use Illuminate\Support\Facades\URL;

class PageRenderer
{
    /**
     * @var string
     */
    private $startTag = '<div class="dd">';
    /**
     * @var string
     */
    private $endTag = '</div>';
    /**
     * @var string
     */
    private $page = '';

    /**
     * @param $menuId
     * @param $menuItems
     * @return string
     */
    public function renderForMenu($pages)
    {
        $this->page .= $this->startTag;
        $this->generateHtmlFor($pages);
        $this->page .= $this->endTag;

        return $this->page;
    }

    /**
     * Generate the html for the given items
     * @param $items
     */
    private function generateHtmlFor($items)
    {
        $this->page .= '<ol class="dd-list">';
        foreach ($items as $item) {
            $this->page .= "<li class=\"dd-item\" data-id=\"{$item->id}\">";
            $editLink = URL::route('admin.page.page.edit', [$item->id]);
            $style = $item->isRoot() ? 'none' : 'inline';
            $this->page .= <<<HTML
<div class="btn-group" role="group" aria-label="Action buttons" style="display: {$style}">
    <a class="btn btn-sm btn-info" style="float:left;" href="{$editLink}">
        <i class="fa fa-pencil"></i>
    </a>
    <a class="btn btn-sm btn-danger jsDeleteMenuItem" style="float:left; margin-right: 15px;" data-item-id="{$item->id}">
       <i class="fa fa-times"></i>
    </a>
</div>
HTML;
            $handleClass = $item->isRoot() ? 'dd-handle-root' : 'dd-handle';
            if (isset($item->icon) && $item->icon != '') {
                $this->page .= "<div class=\"{$handleClass}\"><i class=\"{$item->icon}\" ></i> {$item->title}</div>";
            } else {
                $this->page .= "<div class=\"{$handleClass}\">{$item->title}</div>";
            }

            if ($this->hasChildren($item)) {
                $this->generateHtmlFor($item->items);
            }

            $this->page .= '</li>';
        }
        $this->page .= '</ol>';
    }

    /**
     * @param $item
     * @return bool
     */
    private function hasChildren($item)
    {
        return count($item->items);
    }
}
