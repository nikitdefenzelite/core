<?php namespace App\Http\Requests\Admin;
   use Illuminate\Foundation\Http\FormRequest;use Illuminate\Validation\Rule; class ApiRunnerRequest extends FormRequest { /** * Determine if
    the user is authorized to make this request. * * @return bool */ public function authorize() { return true; } /** *
    Get the validation rules that apply to the request. * * @return array<string, mixed>
    */
    public function rules()
    {

    switch ($this->request_with) {
    case 'create':
    $rules = [        
            'title' => 'required',
            'project_id' => 'required',
            'code' => 'required',
            'status' => 'required',
            'user_id' => 'required',
    
    ];
    break;
    case 'update':
        $rules = [                                                

        'title' => ['required'],'group' => ['required'],'code' => ['required'],'status' => ['required'],'user_id' => ['required'],'project_id' => ['required'],


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
