<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;




class Project extends Model {

    use HasFactory;
    use SoftDeletes;    
    protected $guarded = ['id'];
    protected $casts = [
        'system_variable_payload' => 'array',
        'postman_payload' => 'array'
    ];


                         
    public const BULK_ACTIVATION = 0;     
    public function getPrefix() { 
        return "#P".str_replace('_1','','_'.(100000 +$this->id));
    }
    public function getPostmanPayloadAttribute($value)
    {
        // Check if the value is null or empty
        if (empty($value)) {
            return null;
        }

        // Decode the JSON postman_payload attribute
        return json_decode($value, true);
    }

    /**
     * Get the decoded system_variable_payload attribute.
     *
     * @param  string|null  $value
     * @return mixed
     */
    public function getSystemVariablePayloadAttribute($value)
    {
        // Check if the value is null or empty
        if (empty($value)) {
            return null;
        }

        // Decode the JSON system_variable_payload attribute
        return json_decode($value, true);
    }



    public const TYPE_APIRUNNER = 1;
    public const TYPE_CYPRESS = 2;
    public const TYPES = [
        "1" => ['label' =>'Api Runner'],
        "2" => ['label' =>'Cy Press'],
    ];


}
