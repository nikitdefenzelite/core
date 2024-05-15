<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiRunnerLog extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $guarded = [];
    protected $table = 'api_runner_log';
   

    public const STATUSES = [
        "Running" => ['label' => 'Running', 'color' => 'primary'],
        "Failed" => ['label' => 'Failed', 'color' => 'danger'],
        "Completed" => ['label' => 'Completed', 'color' => 'success'],
    ];
    public const RESULT = [
        "Pass" => ['label' => 'Pass', 'color' => 'success'],
        "Fail" => ['label' => 'Fail', 'color' => 'danger'],
    ];


    protected $casts = [
        'payload' => 'array',
    ];
    public const BULK_ACTIVATION = 0;
    public function getPrefix()
    {
        return "#CRL"
            . str_replace('_1', '', '_' . (100000 + $this->id));
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
