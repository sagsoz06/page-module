<?php

namespace Modules\Page\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Page\Repositories\PageRepository;

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
        \Validator::extend('check_uri', function($attributes, $value, $parameters, $validator) {
            $pageRepository = app(PageRepository::class);
            if($parent = $pageRepository->find($this->request->get('parent_id'))) {
                if(isset($parameters[0])) {
                    $page = $pageRepository->findByUriInLocale($parent->translate($parameters[0])->uri.'/'.$value, $parameters[0]);
                    if($page) {
                        if(isset($parameters[1])) {
                            if($page->id == $parameters[1]) {
                                return true;
                            }
                        }
                    }
                    if($page) {
                        return false;
                    }
                }
            }
            return true;
        }, trans('validation.unique'));


        $id = $this->route()->parameter('page')->id;
        return [
            'title'            => 'required',
            'slug'             => "required|check_uri:$this->localeKey,$id",
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
