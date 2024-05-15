<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DeployConfig;

class DeployConfigController extends Controller
{
    private $resultLimit;

    public function __construct(){
        $this->resultLimit = 10;
    }

    public function store(Request $request,$id = null)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'project_register_id' => 'required',
            'status' => 'required',
            'url' => 'required',
            'host' => 'required',
            'username' => 'required',
            'password' => 'required',
            'port' => 'required',
            'code_structure' => 'required',
            'local_folders' => 'required',
            'core_folders' => 'required',
            'project_directory_path' => 'required',
            'local_directory_path' => 'required',
        ]);

        $payload = [
            'url' => $request->url,
            'host' => $request->host,
            'username' => $request->username,
            'password' => $request->password,
            'port' => $request->port,
            'code_structure' => $request->code_structure,
            'local_folders' => $request->local_folders,
            'core_folders' => $request->core_folders,
            'project_directory_path' => $request->project_directory_path,
            'local_directory_path' => $request->local_directory_path,
        ];
        if($id != null){
            $deploy_config_project_exists = DeployConfig::where('project_register_id',$request->project_register_id)->where('id','!=',$id)->first();
        }else{
            $deploy_config_project_exists = DeployConfig::where('project_register_id',$request->project_register_id)->first();
        }
        if($deploy_config_project_exists){
            return response([
                'status' => 'error',
                'msg' => 'Deploy Config already exists in this project register id!',
            ]);
        }
        
        if($id != null){
            $deploy_config = DeployConfig::where('id',$id)
            ->first();
            if(!$deploy_config){
                return response([
                    'status' => 'error',
                    'msg' => 'Deploy Config not found!',
                ]);
            }
            
            // Update Record
            $deploy_config->update([
                'name' => $request->name,
                'project_register_id' => $request->project_register_id,
                'status' => $request->status,
                'payload' => $payload,
            ]);
        }else{
            DeployConfig::create([
                'name' => $request->name,
                'project_register_id' => $request->project_register_id,
                'status' => $request->status,
                'payload' => $payload,
            ]);
        }
        return response([
            'status' => 'success',
            'message' => 'Deploy Config created successfully!',
        ]);
    }
    public function destroy($id)
    {
        $deploy_config = DeployConfig::where('id',$id)->first();
        if(!$deploy_config){
            return response([
                'status' => 'error',
                'msg' => 'Deploy Config not found!',
            ]);
        }
        $deploy_config->delete();
        return response([
            'status' => 'success',
            'message' => 'Deploy Config deleted successfully!',
        ]);
    }
    public function index(Request $request)
    {
        $page = $request->has('page') && $request->get('page') ? $request->get('page') : 1;
        $limit = $request->has('limit') && $request->get('limit') ? $request->get('limit') : $this->resultLimit;
        $deploy_configs = DeployConfig::query();
        if($request->has('search') && $request->get('search')){
            $deploy_configs->where('id','like','%'.$request->search.'%')
                ->orWhere('name','like','%'.$request->search.'%');
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
        $deploy_configs = $deploy_configs->limit($limit)->offset(($page - 1) * $limit)->get();
        
        return response([
            'status' => 'success',
            'data' => $deploy_configs,
        ]);
    }
    public function show($id)
    {
        $deploy_config = DeployConfig::where('id',$id)->first();
        if(!$deploy_config){
            return response([
                'status' => 'error',
                'msg' => 'Deploy Config not found!',
            ]);
        }
        return response([
            'status' => 'success',
            'data' => $deploy_config,
        ]);
    }
}
