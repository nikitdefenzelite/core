<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202309-V1.3>
 * @link    <https://www.defenzelite.com>
 */


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->request_with) {
            case 'create':
                $rules = [
                    'name' => 'required|regex:/^[a-zA-Z]+.*$/',
                    'code' => 'required| unique:category_types',
                    'allowed_level' => 'required',
                ];
                break;
            case 'update':
                $rules = [
                    'name' => 'required|regex:/^[a-zA-Z]+.*$/',
//                'code' => 'required|unique:category_types',
//                    'allowed_level' => 'required',
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }

    public function messages()
    {
        switch ($this->request_with) {
            case 'create':
                $messages = [
                    'name.required' => 'Name is required',
                    'code.required' => 'Code has been already taken it may be in your trash records.',
                    'allowed_level.required' => 'Level is required',
                ];
                break;
            case 'update':
                $messages = [
                    'name.required' => 'Name is required',
                    'code.required' => 'Code has been already taken it may be in your trash records.',
                    'allowed_level.required' => 'Level is required',
                ];
                break;
            default:
                $messages = [];
                break;
        }
        return $messages;
    }
}
