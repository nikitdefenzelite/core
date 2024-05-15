<{{ $data['wildcard'] }}php /** * Class {{ $migration_name }}Table * * @category ZStarter * * @ref zCURD *
    @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create{{ $migration_name }}Table extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ $data['name'] }}', function (Blueprint $table) {
            $table->id(); @foreach ($data['fields']['name'] as $index => $item) @php    $unique = array_key_exists('unique_'.$index,$data['fields']['options']) ? true : false;    $required = array_key_exists('required_'.$index,$data['fields']['options']) ? true : false;  $nullable = array_key_exists('nullable_'.$index,$data['fields']['options']) ? true : false; $cascade = array_key_exists('cascade_'.$index,$data['fields']['options']) ? true : false;   $default = $data['fields']['default'][$index] != null ? $data['fields']['default'][$index] : false; @endphp @if ($data['fields']['type'][$index] == 'enum')   @if ($required && $default)
                    
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}',[{!! $data['fields']['comment'][$index] !!}])->default({!! is_numeric($default) ? $default : "'" . $default . "'" !!})->comment('{!! $data['fields']['comment'][$index] !!}') ;   @elseif($required)
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}',[{!! $data['fields']['comment'][$index] !!}])->comment('{!! $data['fields']['comment'][$index] !!}') ; @endif @if ($nullable && $default)
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}',[{!! $data['fields']['comment'][$index] !!}])->default({!! is_numeric($default) ? $default : "'" . $default . "'" !!})->comment('{!! $data['fields']['comment'][$index] !!}')->nullable(); @elseif($nullable)
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}',[{!! $data['fields']['comment'][$index] !!}])->comment('{!! $data['fields']['comment'][$index] !!}')->nullable();    @endif @if (!$required && !$nullable && $default)

            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}',[{!! $data['fields']['comment'][$index] !!}])->default({!! is_numeric($default) ? $default : "'" . $default . "'" !!})->comment('{!! $data['fields']['comment'][$index] !!}') ; @elseif(!$required && !$nullable)

            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}',[{!! $data['fields']['comment'][$index] !!}])->comment('{!! $data['fields']['comment'][$index] !!}') ; @endif  @else    @if ($required && $default && $data['fields']['input'][$index] != 'hidden')        @if ($default == 'now()')
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->useCurrent()->comment('{!! $data['fields']['comment'][$index] !!}');  @else
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->default({!! is_numeric($default) ? $default : "'" . $default . "'" !!})->comment('{!! $data['fields']['comment'][$index] !!}'); @endif          @elseif($required && $unique)
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->comment('{!! $data['fields']['comment'][$index] !!}')->unique();  @elseif($required)
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->comment('{!! $data['fields']['comment'][$index] !!}'); @endif  @if ($nullable && $default && $data['fields']['input'][$index] != 'hidden')  @if ($default == 'now()')
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->useCurrent()->comment('{!! $data['fields']['comment'][$index] !!}')->nullable();     @else
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->default({!! is_numeric($default) ? $default : "'" . $default . "'" !!})->comment('{!! $data['fields']['comment'][$index] !!}')->nullable();   @endif          @elseif($nullable && $unique)
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->comment('{!! $data['fields']['comment'][$index] !!}')->nullable()->unique(); @elseif($nullable)
           
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->comment('{!! $data['fields']['comment'][$index] !!}')->nullable();   @endif @if (!$required && !$nullable && $default) @if ($default == 'now()')

            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->useCurrent()->comment('{!! $data['fields']['comment'][$index] !!}'); @elseif($data['fields']['input'][$index] != 'hidden')
            
            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->default({!! is_numeric($default) ? $default : "'" . $default . "'" !!})->comment('{!! $data['fields']['comment'][$index] !!}'); @endif @elseif(!$required && !$nullable)

            $table->{{ $data['fields']['type'][$index] }}('{{ $item }}')->comment('{!! $data['fields']['comment'][$index] !!}'); @endif    @endif   @if ($cascade)
           
            $table->foreign('{{ $item }}')->references('{{ $data['fields']['ref_table'][$index] }}')->on('{{ $data['fields']['ref_col'][$index] }}')@if (array_key_exists('ref_on_update_' . $index, $data['fields']) &&
                    array_key_exists('ref_on_delete_' . $index, $data['fields']))->onUpdate('cascade')->onDelete('cascade')@elseif(array_key_exists('ref_on_update_' . $index, $data['fields']))
            ->onUpdate('cascade')@elseif(array_key_exists('ref_on_delete_' . $index, $data['fields']))->onDelete('cascade')@endif; @endif
    @endforeach

    $table->timestamps(); @if (isset($data['softdelete']))
        $table->softDeletes();
    @endif

    });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
    Schema::dropIfExists('{{ $data['name'] }}');
    }
    }
