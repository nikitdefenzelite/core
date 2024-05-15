<?php /** * Class ApiRunner * * @category ZStarter * * @ref zCURD *
    @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFormattedTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;



class ApiRunner extends Model {
    use SoftDeletes;    
    protected $guarded = ['id'];
    public const STATUS_UNPUBLISHED = 'Unpublished';
    public const STATUS_PUBLISHED = 'Published';
    protected $casts = ['payload'=>'json'];

    public const STATUSES = [
        "Published" => ['label' =>'Draft','color' => 'info'],
        "Unpublished" => ['label' =>'Active','color' => 'success'],
        "Unpublished" => ['label' =>'Discard','color' => 'danger'],
        ];


    public const BULK_ACTIVATION = 1;    public function getPrefix() { return "#AR"
        .str_replace('_1','','_'.(100000 +$this->id));
    }
                                                    
    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    }
