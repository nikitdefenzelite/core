<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CyRunnerRequest;
use App\Models\CyRunner;
use Maatwebsite\Excel\Facades\Excel;

class CyRunnerController extends Controller
{
    
    protected $viewPath; 
    protected $routePath; 
    public function __construct(){
        $this->viewPath = 'admin.cy-runners.';
        $this->routePath = 'admin.cy-runners.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(CyRunnerRequest $request)
     {
         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $cyRunners = CyRunner::query();
         
            if($request->get('search')){
                $cyRunners->where('id','like','%'.$request->search.'%')
                                  
                ->orWhere('code','like','%'.$request->search.'%')
               ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $cyRunners->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $cyRunners->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $cyRunners->orderBy($request->get('desc'),'desc');
            }
            if($request->get('trash') == 1){
                $cyRunners->onlyTrashed();
            }
            $cyRunners = $cyRunners->paginate($length);
            $bulkActivation = CyRunner::BULK_ACTIVATION;
            if ($request->ajax()) {
                return view($this->viewPath.'load', ['cyRunners' => $cyRunners,'bulkActivation'=>$bulkActivation])->render();  
            }
 
        return view($this->viewPath.'index', compact('cyRunners','bulkActivation'));
    }

    public function print(Request $request){
        $cyRunners = collect($request->records['data']);
        return view($this->viewPath.'print', ['cyRunners' => $cyRunners])->render();   
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CyRunnerRequest $request)
    {
        try{           
            $cyRunner = CyRunner::create($request->all());
       
                                    
            if($request->ajax())
                return response()->json([
                    'id'=> $cyRunner->id,
                    'status'=>'success',
                    'message' => 'Success',
                    'title' => 'Record Created Successfully!'
                ]);
            else         
            return redirect()->route($this->routePath.'index')->with('success','Cy Runner Created Successfully!');
        }catch(Exception $e){            
            $bug = $e->getMessage();
            if(request()->ajax())
                return  response()->json([$bug]);
            else
                return redirect()->back()->with('error', $bug)->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CyRunner $cyRunner)
    {
        try{
            return view($this->viewPath.'show',compact('cyRunner'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CyRunner $cyRunner)
    {   
        try{
            return view($this->viewPath.'edit',compact('cyRunner'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CyRunnerRequest $request,CyRunner $cyRunner)
    {
        try{                 
            if($cyRunner){
                         
                $chk = $cyRunner->update($request->all());
                
                if($request->ajax())
                    return response()->json([
                        'id'=> $cyRunner->id,
                        'status'=>'success',
                        'message' => 'Success',
                        'title' => 'Record Updated Successfully!'
                    ]);
                else         
                return redirect()->route($this->routePath.'index')->with('success','Record Updated!');
            }
            return back()->with('error','Cy Runner not found')->withInput($request->all());
        }catch(Exception $e){            
            $bug = $e->getMessage();
            if(request()->ajax())
            return  response()->json([$bug]);
            else
            return redirect()->back()->with('error', $bug)->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CyRunner $cyRunner)
    {
        try{
            if($cyRunner){
                                          
                $cyRunner->delete();
                return back()->with('success','Cy Runner deleted successfully');
            }else{
                return back()->with('error','Cy Runner not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function restore($id)
    {
        try{
           $cyRunner = CyRunner::withTrashed()->where('id', $id)->first();
            if($cyRunner){
                $cyRunner->restore();
                return back()->with('success','Cy Runner restore successfully');
            }else{
                return back()->with('error','Cy Runner not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function moreAction(CyRunnerRequest $request)
    {
        if(!$request->has('ids') || count($request->ids) <= 0){
            return response()->json(['error' => "Please select atleast one record."], 401);
        }
        try{
            switch (explode('-',$request->action)[0]) {              
                case 'status':
                    $action = explode('-',$request->action)[1]; 
                    CyRunner::withTrashed()->whereIn('id', $request->ids)->each(function($q) use($action){
                        $q->update(['status'=>trim($action)]);
                    });
                    return response()->json([
                        'message' => 'Status changed successfully.',
                    ]);
                    break;  ;
    
                case 'Move To Trash':
                    CyRunner::whereIn('id', $request->ids)->delete();
                    return response()->json([
                        'message' => 'Records moved to trashed successfully.',
                    ]);
                    break;
    
                case 'Delete Permanently':
                    
                    for ($i=0; $i < count($request->ids); $i++) {
                        $cyRunner = CyRunner::withTrashed()->find($request->ids[$i]);                         
                        $cyRunner->forceDelete();
                    }
                    return response()->json([
                        'message' => 'Records deleted permanently successfully.',
                    ]);
                    break;
    
                case 'Restore':
                    
                    for ($i=0; $i < count($request->ids); $i++) {
                       $cyRunner = CyRunner::withTrashed()->find($request->ids[$i]);
                       $cyRunner->restore();
                    }
                    return response()->json([
                        'message' => 'Records restored successfully.',
                    ]);
                    break;
    
                case 'Export':

                    return Excel::download(new CyRunnerExport($request->ids), 'CyRunner-'.time().'.csv');
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
      

}
