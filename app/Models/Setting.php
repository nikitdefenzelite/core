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

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'settings';
    protected $guarded = ['id'];

    public const AUTHENTICATIONS = [
        "0" => ['label' =>'Enable'],
        "1" => ['label' =>'Disable'],
    ];


    public const DATE_FORMATS = [
        ['label'=>'2023-04-19', 'format'=>'Y-m-d'],
        ['label'=>'04/19/2023', 'format'=>'m/d/Y'],
        ['label'=>'Tuesday, April 19th 2023', 'format'=>'l, F jS Y'],
        ['label'=>'April 19, 2023', 'format'=>'F j, Y'],

        ['label'=>'2023-04-19 17:30:00', 'format'=>'Y-m-d H:i:s'],
        ['label'=>'04/19/2023 17:30:00', 'format'=>'m/d/Y H:i:s'],
        ['label'=>'Tuesday, April 19th 2023 17:30:00', 'format'=>'l, F jS Y H:i:s'],
        ['label'=>'April 19, 2023 17:30:00', 'format'=>'F j, Y H:i:s'],

        ['label'=>'2023-04-19 5:30 PM', 'format'=>'Y-m-d g:i A'],
        ['label'=>'04/19/2023 5:30 PM', 'format'=>'m/d/Y g:i A'],
        ['label'=>'Tuesday, April 19th 2023 5:30 PM', 'format'=>'l, F jS Y g:i A'],
        ['label'=>'April 19, 2023 5:30 PM', 'format'=>'F j, Y g:i A']
    ];
}
