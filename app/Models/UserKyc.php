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


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserKyc extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_kycs';
    protected $guarded = ['id'];

    public const STATUS_UNDER_APPROVAL = 0;
    public const STATUS_VERIFIED = 1;
    public const STATUS_REJECTED = 2;

    public const STATUSES = [
        "0" => ['label' =>'Under Approval','color' => 'info'],
        "1" => ['label' =>'Verified','color' => 'success'],
        "2" => ['label' =>'Rejected','color' => 'danger'],
    ];

    public function getFrontImageAttribute($value)
    {
        $frontImage = !is_null($value) ? asset($value) :
        'https://ui-avatars.com/api/?name='.$this->first_name.'&background=19B5FE&color=ffffff&v=19B5FE';
        // dd($frontImage);
        if (\Str::contains(request()->url(), '/api')) {
            return asset($frontImage);
        }
        return $frontImage;
    }
    public function getbackImageAttribute($value)
    {
        $backImage = !is_null($value) ? asset($value) :
        'https://ui-avatars.com/api/?name='.$this->first_name.'&background=19B5FE&color=ffffff&v=19B5FE';
        // dd($backImage);
        if (\Str::contains(request()->url(), '/api')) {
            return asset($backImage);
        }
        return $backImage;
    }
    public function getFaceWithDocAttribute($value)
    {
        $FaceWithDoc = !is_null($value) ? asset($value) :
        'https://ui-avatars.com/api/?name='.$this->first_name.'&background=19B5FE&color=ffffff&v=19B5FE';
        // dd($FaceWithDoc);
        if (\Str::contains(request()->url(), '/api')) {
            return asset($FaceWithDoc);
        }
        return $FaceWithDoc;
    }
}
