<?php

namespace Modules\Page\Composers;

use Illuminate\Contracts\View\View;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;

class ThemeAdminAssets
{
    private $assetPipeline;

    public function __construct(AssetPipeline $assetPipeline)
    {
        $this->assetPipeline = $assetPipeline;
    }

    public function compose(View $view)
    {
        $this->assetPipeline->requireCss('bootstrap-colorpicker.css');
        $this->assetPipeline->requireJs('bootstrap-colorpicker.js');
    }
}