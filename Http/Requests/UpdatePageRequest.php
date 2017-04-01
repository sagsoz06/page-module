<?php

namespace Modules\Page\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdatePageRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'page::pages.validation.attributes';

    public function rules()
    {
        return [
            'template' => 'required',
        ];
    }

    public function translationRules()
    {
        $id = $this->route()->parameter('page')->id;
        return [
            'title'            => 'required',
            'slug'             => "required|unique:page__page_translations,slug,$id,page_id,locale,$this->localeKey",
            'body'             => 'required',
            'meta_title'       => 'max:55',
            'meta_description' => 'max:155',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'template.required' => trans('page::messages.template is required'),
            'is_home.unique'    => trans('page::messages.only one homepage allowed'),
        ];
    }

    public function translationMessages()
    {
        return [
            'title.required' => trans('page::messages.title is required'),
            'body.required'  => trans('page::messages.body is required'),
        ];
    }
}
