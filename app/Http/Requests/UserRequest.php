<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202402-V2.0>
 * @link    <https://www.defenzelite.com>
 */


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    'first_name'  => 'required|regex:'.regex('name',1)['pattern'],
                    'last_name'  => 'required|regex:'.regex('name',1)['pattern'],
                    'phone'     => 'sometimes|required|regex:'.regex('phone_number',1)['pattern'],
                    'email'    => 'required|regex:'.regex('email',1)['pattern'],
                    'password' => 'required|regex:'.regex('password',1)['pattern'],
                    'gender' => 'nullable',
                    'role'     => 'required',
                    'dob'     => 'required|regex:'.regex('dob',1)['pattern'],
                ]; 
                break;
            case 'update':
                $rules = [
                    'first_name'     => 'required|regex:'.regex('name',1)['pattern'],
                    'last_name'     => 'required|regex:'.regex('name',1)['pattern'],
                    'phone'     => 'sometimes|required|regex:'.regex('phone_number',1)['pattern'],
                    // 'gender' => 'nullable',
                    'email'    => 'required|regex:'.regex('email',1)['pattern'],
                    'dob'    => 'required',
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
                'first_name.required'     => 'First Name is required',
                'last_name.required'     => 'Last Name is required',
                'email.required'    => 'Email is required',
                // 'email.unique'    => 'Email must be Unique',
                'password.required' => 'Password is required',
                'role.required'     => 'Role is required',
                'phone.required'   => 'Contact Number is required.',
            ];
            break;
        case 'update':
            $messages = [
                'first_name.required'     => 'First Name is required',
                'last_name.required'     => 'Last Name is required',
                'email.required'    => 'Email is required',
                // 'email.unique'    => 'Email must be Unique',
                'phone.required'   => 'Contact Number is required.',

            ];
            break;
        default:
            $messages = [];
        break;
        }
        return $messages;
    }
    protected function prepareForValidation()
    {
        // $this->merge([
        //     'email' => base64_decode($this->email),
        //     'phone' => base64_decode($this->phone),
        // ]);
        foreach ($this->all() as $key => $value) {
            if (strpos($value, 'zDecrypt-') === 0) {
                $this->merge([
                    $key => base64_decode(substr($value, strlen('zDecrypt-'))),
                ]);
            }
        }
    }
}
