<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;



class CyRunner extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    public const STATUS_DRAFT = 'Draft';
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_DISCARD = 'Discard';

    public const STATUSES = [
        "Draft" => ['label' => 'Draft', 'color' => 'info'],
        "Active" => ['label' => 'Active', 'color' => 'success'],
        "Discard" => ['label' => 'Discard', 'color' => 'danger'],
    ];

    public const BULK_ACTIVATION = 0;
    public function getPrefix()
    {
        return "#CR". str_replace('_1', '', '_' . (100000 + $this->id));
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'group_id', 'id');
    }

}
