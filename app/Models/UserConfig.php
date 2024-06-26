<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConfig extends Model
{
    use HasFactory;
    protected $casts = ['payload'=>'json'];
    protected $guarded = ['id'];
}
