<?php namespace Modules\Page\Http\Requests;

use Illuminate\Http\Response;
use Modules\Core\Internationalisation\BaseFormRequest;

class DeletePageRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'pageId' => 'is_home',
        ];
    }

    public function attributes()
    {
        return [
            'pageId' => 'Sayfa'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'is_home' => trans('page::messages.is_home'),
        ];
    }

    public function response(array $errors)
    {
        return response()->json([
            'success'  => false,
            'messages' => $errors
        ], Response::HTTP_BAD_REQUEST);
    }
}