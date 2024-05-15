<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DeployConfig;

class DeployConfigController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $deploy_configs = DeployConfig::query();
         
            if($request->get('search')){
                $deploy_configs->where('id','like','%'.$request->search.'%')
                                ->orWhere('name','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $deploy_configs->whereBetween('created_at', [\Carbon\carbon::parse($request->from)->format('Y-m-d'),\Carbon\Carbon::parse($request->to)->format('Y-m-d')]);
            }

            if($request->get('asc')){
                $deploy_configs->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $deploy_configs->orderBy($request->get('desc'),'desc');
            }
            $deploy_configs = $deploy_configs->paginate($length);

            if ($request->ajax()) {
                return view('panel.deploy_configs.load', ['deploy_configs' => $deploy_configs])->render();  
            }
 
        return view('panel.deploy_configs.index', compact('deploy_configs'));
    }

    
        public function print(Request $request){
            $deploy_configs = collect($request->records['data']);
                return view('panel.deploy_configs.print', ['deploy_configs' => $deploy_configs])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.deploy_configs.create');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'name'     => 'required',
            'project_register_id'     => 'required',
        ]);
        
        try{          
            if(!$request->has('status')){
                $request['status'] = 0;
            }
              
            $deploy_config = DeployConfig::create($request->all());
            return redirect()->route('panel.deploy_configs.index')->with('success','Deploy Config Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(DeployConfig $deploy_config)
    {
        try{
            return view('panel.deploy_configs.show',compact('deploy_config'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(DeployConfig $deploy_config)
    {   
        try{
            
            return view('panel.deploy_configs.edit',compact('deploy_config'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request,DeployConfig $deploy_config)
    {
        
        $this->validate($request, [
            'name'     => 'required',
            'project_register_id'     => 'required',
        ]);
                
        try{
                         
            if(!$request->has('status')){
                $request['status'] = 0;
            }
                          
            if($deploy_config){
                        
                $chk = $deploy_config->update($request->all());

                return redirect()->route('panel.deploy_configs.index')->with('success','Record Updated!');
            }
            return back()->with('error','Deploy Config not found');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(DeployConfig $deploy_config)
    {
        try{
            if($deploy_config){
                                        
                $deploy_config->delete();
                return back()->with('success','Deploy Config deleted successfully');
            }else{
                return back()->with('error','Deploy Config not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
