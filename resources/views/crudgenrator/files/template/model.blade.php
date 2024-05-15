<{{ $data['wildcard'] }}php /** * Class {{ $data['model'] }} * * @category ZStarter * * @ref zCURD *
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
@if (isset($data['softdelete']))
use Illuminate\Database\Eloquent\SoftDeletes;
@endif
{{-- @foreach ($data['fields']['name'] as $index => $item)@if ($data['fields']['input'][$index] == 'select_via_table')
use App\Models\{{ $data['fields']['table'][$index] }};
@endif @endforeach --}}
@if (isset($data['media']) && count($data['media']) > 0)
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
@endif


class {{ $data['model'] }} extends Model @if (isset($data['media']) && count($data['media']) > 0)implements HasMedia @endif
{
    use HasFactory,HasFormattedTimestamps;
    @if (isset($data['softdelete']))use SoftDeletes;@endif
    @if (isset($data['media']) && count($data['media']) > 0)use InteractsWithMedia;@endif

    protected $guarded = ['id'];
    @php $html = ''; @endphp
    @foreach ($data['fields']['type'] as $index => $item) @if ($item == 'json') @php  $html .= "'".$data['fields']['name'][$index]."' => 'array'," @endphp @endif @endforeach @if ($html != '')

    protected $casts = [
        {!! $html !!}
        ]; @endif
        @isset($data['status_filter'])
            public const STATUS_UNPUBLISHED = 'Unpublished';
            public const STATUS_PUBLISHED = 'Published';

            public const STATUSES = [
            "Published" => ['label' =>'Published','color' => 'success'],
            "Unpublished" => ['label' =>'Unpublished','color' => 'danger'],
            ];
        @endisset
    @isset($data['bulk_activation_btn'])
    public const BULK_ACTIVATION = 1;@else

    public const BULK_ACTIVATION = 0; @endif
    public function getPrefix() { return "#{{ preg_replace('~[^A-Z]~', '', $data['model']) }}"
    .str_replace('_1','','_'.(100000 +$this->id));
    }
    @foreach ($data['fields']['name'] as $index => $item)
        @if ($data['fields']['input'][$index] == 'select_via_table')
            public function
            {{ lcfirst(str_replace(' ', '', str_replace('Id', '', ucwords(str_replace('_', ' ', $item))))) }}(){
            return $this->belongsTo({{ $data['fields']['table'][$index] }}::class,'{{ $item }}','id');
            }
        @elseif(
            $data['fields']['input'][$index] == 'select' &&
                str_contains(strip_tags((string) $data['fields']['comment'][$index]), ':'))
            protected function {{ lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $item)))) }}(): Attribute
            {
            $array = getSelectValues([{!! (string) $data['fields']['comment'][$index] !!}],false,":");
            return Attribute::make(
            get: fn ($value) => $array[$value],
            set: fn ($value) => array_search ($value, $array),
            );
            }
        @endif
    @endforeach



    }
