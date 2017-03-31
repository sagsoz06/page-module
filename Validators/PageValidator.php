<?php  namespace Modules\Page\Validators;


use Modules\Page\Entities\Page;

class PageValidator
{
    public function validateIsHome($attribute, $value, $parameters)
    {
        $homePage = Page::where('is_home', 1)->where('id', $value)->first();
        return (bool) isset($homePage) ? false : true;
    }
}