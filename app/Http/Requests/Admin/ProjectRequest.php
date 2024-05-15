<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    /** * Determine if
    the user is authorized to make this request. * * @return bool */ public function authorize()
    {
        return true;
    }
    /** *
    Get the validation rules that apply to the request. * * @return array<string, mixed>
     */
    public function rules()
    {

        switch ($this->request_with) {
            case 'create':
                $rules = [
                    'name' => 'required',
                    'system_variable_payload' => 'required',
                    // 'postman_payload' => 'required',
                    'project_register_id' => 'required',

                ];
                break;
            case 'update':
                $rules = [
                    'name' => ['required'], 
                    'project_register_id' => ['required'],
                    // 'postman_payload' => ['required'],
                     'project_register_id' => ['required'],

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
                $messages = [];
                break;
            case 'update':
                $messages = [];
                break;
            default:
                $messages = [];
                break;
        }
        return $messages;
    }
}
