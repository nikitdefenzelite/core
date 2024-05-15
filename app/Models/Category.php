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
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'categories';
    protected $guarded = ['id'];

    public const TYPE_MAIN = 0;
    public const TYPE_SUB = 1;
    public const TYPE_SUB_SUB = 2;
    public function getPrefix()
    {
        return "#MC".str_replace('_1', '', '_'.(100000 +$this->id));
    }
    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class, 'category_type_id');
    }
    public const TYPES = [
        "0" => ['label' =>'Main'],
        "1" => ['label' =>'Sub'],
        "2" => ['label' =>'Sub-Sub'],
    ];
    protected function typeParsed(): Attribute
    {
        return  Attribute::make(
            get: fn ($value) =>  (object)self::TYPES[$this->type],
        );
    }
    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    public const STATUS_TYPE_APIRUNNER = 1;
    public const STATUS_TYPE_CYPRESS = 2;
    public const STATUS_TYPES = [
        "1" => ['label' =>'Api Runner'],
        "2" => ['label' =>'Cy Press'],
    ];
}
