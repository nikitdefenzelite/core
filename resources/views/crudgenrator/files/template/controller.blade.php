<{{ $data['wildcard'] }}php
    @if ($data['controller_namespace']) namespace App\Http\Controllers\{{ $data['controller_namespace'] }};
use App\Http\Controllers\Controller;
@else
namespace App\Http\Controllers; @endif
    use Illuminate\Http\Request; use App\Http\Requests\{{ ucfirst($data['view_path']) }}\{{ $data['model'] }}Request;
    use App\Models\{{ $data['model'] }};
    use Exception;
    @isset($data['export_btn'])
use App\Exports\{{ $data['model'] }}Export;
@endisset
    @isset($data['import_btn'])
use App\Imports\{{ $data['model'] }}Import;
@endisset use
    Maatwebsite\Excel\Facades\Excel; class {{ $data['model'] }}Controller extends Controller { protected $viewPath;
    protected $routePath; public $label; public function __construct(){
    $this->viewPath = '{{ $data['dotviewpath'] }}{{ $data['view_name'] }}.';
    $this->routePath = '{{ $data['dotroutepath'] . $data['view_name'] }}.';
    $this->label = '{{$indexheading}}';
    } /** * Display a listing of the resource. *
    * @return \Illuminate\Http\Response */ public function index(Request $request) { $length=10; if(request()->
    get('length')){
    $length = $request->get('length');
    }
    {{ $indexvariable }} = {{ $data['model'] }}::query();

    if($request->get('search')){
    {{ $indexvariable }}->where('id','like','%'.$request->search.'%')
    @foreach (getKeysByValue('cansearch', $data['fields']['options']) as $item)
        @php $key = explode('_',$item)[1];@endphp
        ->orWhere('{{ $data['fields']['name'][$key] }}','like','%'.$request->search.'%')
    @endforeach;
    }

    if($request->get('from') && $request->get('to')) {
    {{ $indexvariable }}->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').'
    00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
    }

    if($request->get('asc')){
    {{ $indexvariable }}->orderBy($request->get('asc'),'asc');
    }
    if($request->get('desc')){
    {{ $indexvariable }}->orderBy($request->get('desc'),'desc');
    }
    @isset($data['status_filter'])
    if ($request->has('status') && $request->get('status') != null) {
    {{ $indexvariable }}->where('status', $request->get('status'));
    }
    @endisset
    if($request->get('trash') == 1){
    {{ $indexvariable }}->onlyTrashed();
    }
    {{ $indexvariable }} = {{ $indexvariable }}->paginate($length);
    $label = $this->label;
    $bulkActivation = {{ $data['model'] }}::BULK_ACTIVATION;
    if ($request->ajax()) {
    return view($this->viewPath.'load', ['{{ substr($indexvariable, 1) }}' =>
    {{ $indexvariable }},'bulkActivation'=>$bulkActivation])->render();
    }

    return view($this->viewPath.'index', compact('{{ substr($indexvariable, 1) }}','bulkActivation','label'));
    }

    public function print(Request $request){
    $length = @$request->limit ?? 5000;
    $print_mode = true;
    $bulkActivation = {{ $data['model'] }}::BULK_ACTIVATION;
    {{ $indexvariable }}_arr = collect($request->records['data'])->pluck('id');
    {{ $indexvariable }} = {{ $data['model'] }}::whereIn('id', {{ $indexvariable }}_arr)->paginate($length);
    return view($this->viewPath.'print',
    compact('{{ substr($indexvariable, 1) }}','bulkActivation','print_mode'))->render();
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
    try{
    return view($this->viewPath.'create');
    }catch(Exception $e){
    return back()->with('error', 'There was an error: ' . $e->getMessage());
    }
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store({{ $data['model'] }}Request $request)
    {
    try{@foreach ($data['fields']['input'] as $key => $input_type)
        @if ($input_type == 'checkbox' || $input_type == 'radio')
            if(!$request->has('{{ $data['fields']['name'][$key] }}')){
            $request['{{ $data['fields']['name'][$key] }}'] = 0;
            }
        @endif
        @endforeach @foreach ($data['fields']['input'] as $key => $input_type)
            @if ($input_type == 'file')
                if($request->hasFile("{{ $data['fields']['name'][$key] }}_file")){
                $request['{{ $data['fields']['name'][$key] }}'] =
                $this->uploadFile($request->file("{{ $data['fields']['name'][$key] }}_file"),
                "{{ $data['view_name'] }}")->getFilePath();
                } else {
                return $this->error("Please upload an file for {{ $data['fields']['name'][$key] }}");
                }
            @endif
        @endforeach

        {{ $variable }} = {{ $data['model'] }}::create($request->all());

        @if (array_key_exists('media', $data))
            @foreach ($data['media']['name'] as $index => $item)
                @if (array_key_exists('multiple_' . $index, $data['media']['options']))
                    if ($request->hasFile('{{ $item }}')) {
                    $fileAdders =
                    {{ $variable }}->addMultipleMediaFromRequest(['{{ $item }}'])->each(function
                    ($fileAdder)
                    {
                    $fileAdder->toMediaCollection('{{ $item }}');
                    });
                    }
                @else
                if ($request->hasFile('{{ $item }}')) {
                {{ $variable }}->addMultipleMediaFromRequest(['{{ $item }}'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('{{ $item }}');
                });
                }
                @endif
            @endforeach
        @endif
        @if (array_key_exists('mail', $data) && $data['mail'] == 1)
            /**
            * $mailcontent_data = App\Models\MailSmsTemplate::where('code','=',"Welcome")->first();
            * $arr=[
            * '{name}'=>"User",
            * '{id}'=>"MYID",
            * '{phone}'=>"",
            * '{email}'=>"",
            * ];
            * customMail("Admin",getSetting('admin_email'),$mailcontent_data,$arr,null ,null ,$action_btn = null
            ,asset('storage/backend/logos/white-logo-662.png') ,"white-logo-662.png" ,$attachment_mime = null);
            */
        @endif
        @if (array_key_exists('notification', $data) && $data['notification'] == 1)
            /**
            * $data_notification = [
            * 'title' => "New Information ",
            * 'notification' => "{{ $data['model'] }} Created Successfully!",
            * 'link' => "#",
            * 'user_id' => auth()->id(),
            * ];
            * pushOnSiteNotification($data_notification);
            */
        @endif

        if($request->ajax())
        return response()->json([
        'id'=> {{ $variable }}->id,
        'status'=>'success',
        'message' => 'Success',
        'title' => 'Record Created Successfully!'
        ]);
        else
        return redirect()->route($this->routePath.'index')->with('success','{{ $heading }} Created
        Successfully!');
        }catch(Exception $e){
        $bug = $e->getMessage();
        if(request()->ajax())
        return response()->json([$bug]);
        else
        return redirect()->back()->with('error', $bug)->withInput($request->all());
        }
        }

        /**
        * Display the specified resource.
        *
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        public function show(Request $request,$id)
        {
        try{
        if (!is_numeric($id)) {
        $id = decrypt($id);
        }
        {{ $variable }} = {{ $data['model'] }}::where('id',$id)->first();
        return view($this->viewPath.'show',compact('{{ substr($variable, 1) }}'));
        }catch(Exception $e){
        return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
        }

        /**
        * Show the form for editing the specified resource.
        *
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        public function edit(Request $request,$id)
        {
        try{
        if (!is_numeric($id)) {
        $id = decrypt($id);
        }
        {{ $variable }} = {{ $data['model'] }}::where('id',$id)->first();
        return view($this->viewPath.'edit',compact('{{ substr($variable, 1) }}'));
        }catch(Exception $e){
        return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
        }

        /**
        * Update the specified resource in storage.
        *
        * @param \Illuminate\Http\Request $request
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        public function update({{ $data['model'] }}Request $request,$id)
        {
        try{@foreach ($data['fields']['input'] as $key => $input_type)
            @if ($input_type == 'checkbox' || $input_type == 'radio')
                if(!$request->has('{{ $data['fields']['name'][$key] }}')){
                $request['{{ $data['fields']['name'][$key] }}'] = 0;
                }
            @endif
        @endforeach
        {{-- {{ $variable }} = {{ $data['model'] }}::find($id); --}}
        if (!is_numeric($id)) {
        $id = decrypt($id);
        }
        {{ $variable }} = {{ $data['model'] }}::where('id',$id)->first();
        if({{ $variable }}){
        @foreach ($data['fields']['input'] as $key => $input_type)
            @if ($input_type == 'file')
                if($request->hasFile("{{ $data['fields']['name'][$key] }}_file")){
                $request['{{ $data['fields']['name'][$key] }}'] =
                $this->uploadFile($request->file("{{ $data['fields']['name'][$key] }}_file"),
                "{{ $data['view_name'] }}")->getFilePath();
                $this->deleteStorageFile({{ $variable }}->{{ $data['fields']['name'][$key] }});
                } else {
                $request['{{ $data['fields']['name'][$key] }}'] =
                {{ $variable }}->{{ $data['fields']['name'][$key] }};
                }
            @endif
        @endforeach

        $chk = {{ $variable }}->update($request->all());
        @if (array_key_exists('media', $data))
            @foreach ($data['media']['name'] as $index => $item)
                @if (array_key_exists('multiple_' . $index, $data['media']['options']))
                    if ($request->hasFile('{{ $item }}')) {
                    {{ $variable }}->addMultipleMediaFromRequest(['{{ $item }}'])->each(function
                    ($fileAdder)
                    {
                    $fileAdder->toMediaCollection('{{ $item }}');
                    });
                    }
                @else
                    if ($request->hasFile('{{ $item }}'))
                    {
                    if ({{ $variable }}->getMedia('{{ $item }}')->count() > 0) {
                    {{ $variable }}->clearMediaCollection('{{ $item }}');
                    }
                {{ $variable }}->addMultipleMediaFromRequest(['{{ $item }}'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('{{ $item }}');
                });
                   // {{ $variable }}->addMediaFromRequest('{{ $item }}')->toMediaCollection('{{ $item }}');
                    }
                @endif
            @endforeach
        @endif

        if($request->ajax())
        return response()->json([
        'id'=> {{ $variable }}->id,
        'status'=>'success',
        'message' => 'Success',
        'title' => 'Record Updated Successfully!'
        ]);
        else
        return redirect()->route($this->routePath.'index')->with('success','Record Updated!');
        }
        return back()->with('error','{{ $heading }} not found')->withInput($request->all());
        }catch(Exception $e){
        $bug = $e->getMessage();
        if(request()->ajax())
        return response()->json([$bug]);
        else
        return redirect()->back()->with('error', $bug)->withInput($request->all());
        }
        }

        /**
        * Remove the specified resource from storage.
        *
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        public function destroy($id)
        {
        try{
        if (!is_numeric($id)) {
        $id = decrypt($id);
        }
        {{ $variable }} = {{ $data['model'] }}::where('id',$id)->first();
        if({{ $variable }}){
        @foreach ($data['fields']['input'] as $key => $input_type)
            @if ($input_type == 'file')
                $this->deleteStorageFile({{ $variable }}->{{ $data['fields']['name'][$key] }});
            @endif
        @endforeach

        {{ $variable }}->delete();
        return back()->with('success','{{ $heading }} deleted successfully');
        }else{
        return back()->with('error','{{ $heading }} not found');
        }
        }catch(Exception $e){
        return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
        }@isset($data['softdelete'])
            public function restore($id)
            {
            try{
            {{ $variable }} = {{ $data['model'] }}::withTrashed()->where('id', $id)->first();
            if({{ $variable }}){
            {{ $variable }}->restore();
            return back()->with('success','{{ $heading }} restore successfully');
            }else{
            return back()->with('error','{{ $heading }} not found');
            }
            }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
            }
            }
        @endisset


        public function moreAction({{ $data['model'] }}Request $request)
        {
        if(!$request->has('ids') || count($request->ids) <= 0){ return response()->json(['error' => "Please select
            atleast one record."], 401);
            }
            try{
            switch (explode('-',$request->action)[0]) {
            @foreach ($data['fields']['name'] as $index => $item)
                @if ($data['fields']['input'][$index] == 'select')
                    case '{{ $item }}':
                    $action = explode('-',$request->action)[1]; @isset($data['softdelete'])
                        {{ $data['model'] }}::withTrashed()->whereIn('id', $request->ids)->each(function($q) use($action){
                        $q->update(['{{ $item }}'=>trim($action)]);
                        });
                    @else
                        {{ $data['model'] }}::whereIn('id', $request->ids)->each(function($q) use($action){
                        $q->update(['{{ $item }}'=>trim($action)]);
                        });
                    @endisset

                    return response()->json([
                    'message' => '{{ ucwords(str_replace('_', ' ', $item)) }} changed successfully.',
                    'count' => 0,
                    ]);
                    break;
                @elseif($data['fields']['input'][$index] == 'checkbox' || $data['fields']['input'][$index] == 'radio')
                    case '{{ $item }}':@isset($data['softdelete'])
                        {{ $data['model'] }}::withTrashed()->whereIn('id',
                        $request->ids)->update(['{{ $item }}'=>trim(explode('-',$request->action)[1])]);
                        @else{{ $data['model'] }}::whereIn('id',
                        $request->ids)->update(['{{ $item }}'=>trim(explode('-',$request->action)[1])]);
                    @endisset

                    return response()->json([
                    'message' => '{{ ucwords(str_replace('_', ' ', $item)) }} changed successfully.',
                    'count' => 0,
                    ]);
                    break;
                @endif
            @endforeach

            case 'Move To Trash':
            {{ $data['model'] }}::whereIn('id', $request->ids)->delete();
            $count = {{ $data['model'] }}::count();
            return response()->json([
            'message' => 'Records moved to trashed successfully.',
            'count' => $count,
            ]);
            break;

            case 'Delete Permanently':

            for ($i=0; $i < count($request->ids); $i++) {@isset($data['softdelete'])
                    {{ $variable }} = {{ $data['model'] }}::withTrashed()->find($request->ids[$i]);
                @else
                    {{ $variable }} = {{ $data['model'] }}::find($request->ids[$i]);
                @endisset
                {{ $variable }}->forceDelete();
                }
                return response()->json([
                'message' => 'Records deleted permanently successfully.',
                ]);
                break;
    case 'Restore':
    for ($i=0; $i < count($request->ids); $i++) {@isset($data['softdelete'])
        {{ $variable }} = {{ $data['model'] }}::withTrashed()->find($request->ids[$i]);
    @else
        {{ $variable }} = {{ $data['model'] }}::find($request->ids[$i]);
    @endisset
    {{ $variable }}->restore();
    }
    return response()->json(
    [
    'message' => 'Records restored successfully.',
    'count' => 0,
    ]
    );
    break;

                case 'Export':

                return Excel::download(new {{ $data['model'] }}Export($request->ids),
                '{{ $data['model'] }}-'.time().'.xlsx');
                return response()->json(['error' => "Sorry! Action not found."], 401);
                break;

                default:

                return response()->json(['error' => "Sorry! Action not found."], 401);
                break;
                }
                }catch(Exception $e){
                return response()->json(['error' => "Sorry! Action not found."], 401);
                }
                }

                @if (isset($data['media']) && count($data['media']) > 0)
                    {{-- public function destroyMedia({{ $data['model'] }} {{ $variable }},{{ $data['model'] }}Request $request)
    {
        try{
            if({{ $variable }}){
                if ({{ $variable }}->getMedia($request->media)->count()) {
                    {{ $variable }}->clearMediaCollection($request->media);
                }
                return back()->with('success','Media deleted successfully');
            }else{
                return back()->with('error','Media not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    } --}}
                @endif @isset($data['export_btn'])
                public function export({{ $data['model'] }}Request $request)
                {
                try{
                return Excel::download(new {{ $data['model'] }}Export([]),
                '{{ $data['view_name'] }}-'.time().'.xlsx');
                }catch(Exception $e){
                return back()->with('error', 'There was an error: ' . $e->getMessage());
                }
                }
                @endisset @isset($data['import_btn'])
                public function import({{ $data['model'] }}Request $request)
                {
                $import = new {{ $data['model'] }}Import;
                Excel::import($import, request()->file('file'));
               if (isset($import->importData['errors'])) {
               return back()->with('error', $import->importData['errors']['message']);
                 }
                return response()->json([
                'message' => 'xlsx file imported successfully.',
                ]);
                }
            @endisset


            }
