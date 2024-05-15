<{{ $data['wildcard'] }}php namespace App\Http\Requests\{{ ucfirst($data['view_path']) }};
   use Illuminate\Foundation\Http\FormRequest;use Illuminate\Validation\Rule; class {{ $data['model'] }}Request extends FormRequest { /** * Determine if
    the user is authorized to make this request. * * @return bool */ public function authorize() { return true; } /** *
    Get the validation rules that apply to the request. * * @return array<string, mixed>
    */
    public function rules()
    {

    switch ($this->request_with) {
    case 'create':
    $rules = [@foreach ($data['validations']['field'] as $index => $item)
        '{{ $item }}' => '{{ $data['validations']['rules'][$index] }}',
    @endforeach

    ];
    break;
    case 'update':
    @php
        $rules = [];
    @endphp
    $rules = [@foreach ($data['validations']['field'] as $index => $item)
        @php
            $rule = $data['validations']['rules'][$index];
             if (strpos($rule, 'unique') !== false){
                 preg_match('/unique:([^,]+),([^,]+)/', $rule, $matches);
                 $tableName = $matches[1] ?? null;
                 $columnName = $matches[2] ?? null;
                 if ($tableName && $columnName){
                     $item_val = str_replace('unique:' . $tableName . ',' . $columnName, "Rule::unique('$tableName', '$columnName')->ignore(\$this->id)", $rule);
                 } else {
                     $item_val = $data['validations']['rules'][$index];
                 }
             } else {
                 $item_val = $data['validations']['rules'][$index];
             }


             $rule = trim($item_val);
             $sub_rules = explode('|',$rule);
             $item_val = $sub_rules;

             foreach ($sub_rules as $key => $sub_rule){
                if (strpos($sub_rule, 'unique') !== false) {
                    continue;
                 }
                 $sub_rules[$key] = "'" . $sub_rule . "'";
             }

             $item_val = implode('|',$sub_rules);
             $rules[] = "'$item' => [$item_val]";
        @endphp
    @endforeach


    {{--  To Convertion of | Seperated Values to Quotes Values.  --}}
    @php
        $implode_value = implode('|', $rules);
        $implode_value_alt = str_replace('|',',',$implode_value);
    @endphp

        {!! $implode_value_alt !!},

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
$messages = [@foreach ($data['validations']['field'] as $index => $item)
{{--    @php--}}
{{--        $rule = $data['validations']['rules'][$index];--}}
{{--    @endphp--}}
{{--    @if (strpos($rule, 'required') !== false)--}}
{{--    '{{ $item }}' => '{{  ucfirst($item) }} is required',--}}
{{--    @endif--}}
@endforeach

];
break;
case 'update':
$messages = [@foreach ($data['validations']['field'] as $index => $item)
{{--    @php--}}
{{--        $rule = $data['validations']['rules'][$index];--}}
{{--    @endphp--}}
{{--    @if (strpos($rule, 'required') !== false)--}}
{{--        '{{ $item }}' => '{{  ucfirst($item) }} is required',--}}
{{--    @endif--}}
@endforeach

];
break;
default:
$messages = [];
break;
}
return $messages;
}
    }
