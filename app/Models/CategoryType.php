<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202309-V1.3>
 * @link    <https://www.defenzelite.com>
 */


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasFormattedTimestamps;

class CategoryType extends Model
{
    use HasFactory,SoftDeletes;
    


    protected $table = 'category_types';
    protected $guarded = ['id'];
    public function getPrefix()
    {
        return "#MCT".str_replace('_1', '', '_'.(100000 +$this->id));
    }
    public function categories()
    {
        return $this->hasMany(Category::class, 'category_type_id');
    }
}
