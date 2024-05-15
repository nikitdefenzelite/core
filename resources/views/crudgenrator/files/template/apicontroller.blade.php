<{{ $data['wildcard'] }}php /** * Class {{ $data['model'] }}Controller * * @category ZStarter * * @ref zCURD *
    @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */

@if ($data['controller_namespace'])
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
@else
namespace App\Http\Controllers;
@endif
use Illuminate\Http\Request;
use App\Models\{{ $data['model'] }};

class {{ $data['model'] }}Controller extends Controller
{
   
    private $resultLimit;

    public function __construct(){
        $this->resultLimit = 10;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            {{ $indexvariable }} = {{ $data['model'] }}::query();

            if($request->get('search')){
                {{ $indexvariable }}->where('id','like','%'.$request->search.'%')@foreach (getKeysByValue('cansearch', $data['fields']['options']) as $item)  @php $key = explode('_',$item)[1];@endphp
                
                ->orWhere('{{ $data['fields']['name'][$key] }}','like','%'.$request->search.'%') @endforeach
                
                ;
            }
            
            {{ $indexvariable }} = {{ $indexvariable }}->limit($limit)->offset(($page - 1) * $limit)->get();

            return $this->success({{ $indexvariable }});
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try{
        @if (count($data['validations']['field']) > 0 && $data['validations']['field'][0] != null)
        
            $this->validate($request, [@foreach ($data['validations']['field'] as $index => $item)
                '{{ $item }}' => '{{ $data['validations']['rules'][$index] }}',@endforeach

            ]);
        @endif @foreach ($data['fields']['input'] as $key => $input_type) @if ($input_type == 'file')

                    if($request->hasFile("{{ $data['fields']['name'][$key] }}_file")){
                        $request['{{ $data['fields']['name'][$key] }}'] = $this->uploadFile($request->file("{{ $data['fields']['name'][$key] }}_file"), "{{ $data['view_name'] }}")->getFilePath();
                    } else {
                        return $this->error("Please upload an file for {{ $data['fields']['name'][$key] }}");
                    } @endif @endforeach

            {{ $variable }} = {{ $data['model'] }}::create($request->all());

            if({{ $variable }}){
                return $this->success({{ $variable }}, 201);
            }else{
                return $this->error("Error: Record not Created!");
            }

        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }


    /**
    * Return single instance of the requested resource
    *
    * @param {{ $data['model'] }} {{ $variable }}
    * @return \Illuminate\Http\JsonResponse
    */
    public function show({{ $data['model'] }} {{ $variable }})
    {
        try{
            return $this->success({{ $variable }});
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, {{ $data['model'] }} {{ $variable }})
    {
        try{@if (count($data['validations']['field']) > 0 && $data['validations']['field'][0] != null)
        
            $this->validate($request, [@foreach ($data['validations']['field'] as $index => $item)

                '{{ $item }}' => '{{ $data['validations']['rules'][$index] }}',@endforeach

            ]);
        @endif @foreach ($data['fields']['input'] as $key => $input_type)@if ($input_type == 'file')

            if($request->hasFile("{{ $data['fields']['name'][$key] }}_file")){
                $request['{{ $data['fields']['name'][$key] }}'] = $this->uploadFile($request->file("{{ $data['fields']['name'][$key] }}_file"), "{{ $data['view_name'] }}")->getFilePath();
                $this->deleteStorageFile({{ $variable }}->{{ $data['fields']['name'][$key] }});
            } else {
                $request['{{ $data['fields']['name'][$key] }}'] = {{ $variable }}->{{ $data['fields']['name'][$key] }};
            } @endif @endforeach

            {{ $variable }} = {{ $variable }}->update($request->all());

            return $this->success({{ $variable }}, 201);
        } catch(\Exception $e){
            return $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    
     public function destroy($id)
     {
         try{
            {{ $variable }} = {{ $data['model'] }}::findOrFail($id);
            @foreach ($data['fields']['input'] as $key => $input_type) @if ($input_type == 'file')

                 $this->deleteStorageFile({{ $variable }}->{{ $data['fields']['name'][$key] }}); @endif
    @endforeach

    {{ $variable }}->delete();

    return $this->successMessage("{{ $data['model'] }} deleted successfully!");
    } catch(\Exception $e){
    return $this->error("Error: " . $e->getMessage());
    }
    }

    }
