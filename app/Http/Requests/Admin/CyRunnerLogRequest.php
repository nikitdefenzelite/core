<?php namespace App\Http\Requests\Admin;
   use Illuminate\Foundation\Http\FormRequest;use Illuminate\Validation\Rule; class CyRunnerLogRequest extends FormRequest { /** * Determine if
    the user is authorized to make this request. * * @return bool */ public function authorize() { return true; } /** *
    Get the validation rules that apply to the request. * * @return array<string, mixed>
    */
    public function rules()
    {

    switch ($this->request_with) {
    case 'create':
    $rules = [        'group_id' => 'required|integer',
            'user_id' => 'required',
            'payload' => 'required',
            'status' => 'required',
            'result' => 'required',
    
    ];
    break;
    case 'update':
        $rules = [                    
    
        'group_id' => ['required','integer'],'user_id' => ['required'],'payload' => ['required'],'status' => ['required'],'result' => ['required'],

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
