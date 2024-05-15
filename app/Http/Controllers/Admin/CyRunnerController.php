<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CyRunnerRequest;
use App\Models\CyRunner;
use App\Models\Project;
use App\Models\Category;
use Exception;
use
    Maatwebsite\Excel\Facades\Excel;

class CyRunnerController extends Controller
{
    protected $viewPath;
    protected $routePath;
    public $label;
    public function __construct()
    {
        $this->viewPath = 'panel.admin.cy-runners.';
        $this->routePath = 'admin.cy-runners.';
        $this->label = 'Cy Runners';
    }
    /** * Display a listing of the resource. *
     * @return \Illuminate\Http\Response */ 
    public function index(Request $request)
    {
        $length = 10;
        if (request()->get('length')
        ) {
            $length = $request->get('length');
        }
    $cyRunners = CyRunner::query();

        if ($request->get('from') && $request->get('to')) {
            $cyRunners->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d') . '
            00:00:00', \Carbon\Carbon::parse($request->to)->format('Y-m-d') . " 23:59:59"]);
        }

        if ($request->get('search')) {
            $cyRunners->where('id', 'like', '%' . $request->search . '%')->orWhere('name', 'like', '%' . $request->search . '%');
        }

        if ($request->get('asc')) {
            $cyRunners->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $cyRunners->orderBy($request->get('desc'), 'desc');
        }
        if ($request->has('status') && $request->get('status') != null) {
            $cyRunners->where('status', $request->get('status'));
        }
        
        if ($request->has('category_id')) {
            $cyRunners->where('group_id', $request->get('category_id'));
        }
        if ($request->get('trash') == 1) {
            $cyRunners->onlyTrashed();
        }

        
        $project = null;
        if(request()->has('project_id') && request()->get('project_id')){
            $project_id = request()->get('project_id');
            if (!is_numeric($project_id)) {
                $project_id = decrypt($project_id);
            }
            $project = Project::where('id', $project_id)->first();
            $cyRunners->where('project_id', $project_id);
        }
        $cyRunners = $cyRunners->latest();
        $cyRunners = $cyRunners->paginate($length);
        $label = $this->label;
        $bulkActivation = CyRunner::BULK_ACTIVATION;
        if ($request->ajax()) {
            return view($this->viewPath . 'load', ['cyRunners' =>
            $cyRunners, 'bulkActivation' => $bulkActivation])->render();
        }
        

        return view($this->viewPath . 'index', compact('cyRunners', 'bulkActivation', 'label','project'));
    }

    public function print(Request $request)
    {
        $length = @$request->limit ?? 5000;
        $print_mode = true;
        $bulkActivation = CyRunner::BULK_ACTIVATION;
        $cyRunners_arr = collect($request->records['data'])->pluck('id');
        $cyRunners = CyRunner::whereIn('id', $cyRunners_arr)->paginate($length);
        return view(
            $this->viewPath . 'print',
            compact('cyRunners', 'bulkActivation', 'print_mode')
        )->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        try {
            if (!is_numeric($request->project_id)) {
                $project_id = secureToken($request->project_id, 'decrypt');
            }   
            $groups = Category::where('category_type_id', $project_id)->where('type_id', Category::STATUS_TYPE_CYPRESS)->get();
            return view($this->viewPath . 'create', compact('groups'))->render();
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CyRunnerRequest $request)
    {
        try {
            $sequence = CyRunner::count();
            $request['sequence'] = $sequence+1;
            $cyRunner = CyRunner::create($request->all());

            if ($request->ajax())
                return response()->json([
                    'id' => $cyRunner->id,
                    'status' => 'success',
                    'message' => 'Success',
                    'title' => 'Record Created Successfully!'
                ]);
            else
                return redirect()->route($this->routePath . 'index')->with('success', 'Cy Runner Created
        Successfully!');
        } catch (Exception $e) {
            $bug = $e->getMessage();
            if (request()->ajax())
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
    public function show(Request $request, $id)
    {
        try {
            if (!is_numeric($id)) {
                $id = decrypt($id);
            }
            $cyRunner = CyRunner::where('id', $id)->first();
            return view($this->viewPath . 'show', compact('cyRunner'));
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        try {
            if (!is_numeric($id)) {
                $id = decrypt($id);
            }
            $sequence = CyRunner::count();
            $request['sequence'] = $sequence+1;
            $cyRunner = CyRunner::where('id', $id)->first();
            $groups = Category::where('category_type_id', $cyRunner->project_id)->where('type_id', Category::STATUS_TYPE_CYPRESS)->get();
            return view($this->viewPath . 'edit', compact('cyRunner', 'groups'));
        } catch (Exception $e) {
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
    public function update(CyRunnerRequest $request, $id)
    {
        try {
            if (!is_numeric($id)) {
                $id = decrypt($id);
            }
            $cyRunner = CyRunner::where('id', $id)->first();
          
            if ($cyRunner) {

                $chk = $cyRunner->update($request->all());

                if ($request->ajax())
                    return response()->json([
                        'id' => $cyRunner->id,
                        'status' => 'success',
                        'message' => 'Success',
                        'title' => 'Record Updated Successfully!'
                    ]);
                else
                    return redirect()->route($this->routePath . 'index')->with('success', 'Record Updated!');
            }
            return back()->with('error', 'Cy Runner not found')->withInput($request->all());
        } catch (Exception $e) {
            $bug = $e->getMessage();
            if (request()->ajax())
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
        try {
            if (!is_numeric($id)) {
                $id = decrypt($id);
            }
            $cyRunner = CyRunner::where('id', $id)->first();
            if ($cyRunner) {

                $cyRunner->delete();
                return back()->with('success', 'Cy Runner deleted successfully');
            } else {
                return back()->with('error', 'Cy Runner not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function restore($id)
    {
        try {
            $cyRunner = CyRunner::withTrashed()->where('id', $id)->first();
            if ($cyRunner) {
                $cyRunner->restore();
                return back()->with('success', 'Cy Runner restore successfully');
            } else {
                return back()->with('error', 'Cy Runner not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    public function moreAction(CyRunnerRequest $request)
    {
        if (!$request->has('ids') || count($request->ids) <= 0) {
            return response()->json(['error' => "Please select
            atleast one record."], 401);
        }
        try {
            switch (explode('-', $request->action)[0]) {
                case 'status':
                    $action = explode('-', $request->action)[1];
                    CyRunner::withTrashed()->whereIn('id', $request->ids)->each(function ($q) use ($action) {
                        $q->update(['status' => trim($action)]);
                    });

                    return response()->json([
                        'message' => 'Status changed successfully.',
                        'count' => 0,
                    ]);
                    break;

                case 'Move To Trash':
                    CyRunner::whereIn('id', $request->ids)->delete();
                    $count = CyRunner::count();
                    return response()->json([
                        'message' => 'Records moved to trashed successfully.',
                        'count' => $count,
                    ]);
                    break;

                case 'Delete Permanently':

                    for ($i = 0; $i < count($request->ids); $i++) {
                        $cyRunner = CyRunner::withTrashed()->find($request->ids[$i]);
                        $cyRunner->forceDelete();
                    }
                    return response()->json([
                        'message' => 'Records deleted permanently successfully.',
                    ]);
                    break;
                case 'Restore':
                    for ($i = 0; $i < count($request->ids); $i++) {
                        $cyRunner = CyRunner::withTrashed()->find($request->ids[$i]);
                        $cyRunner->restore();
                    }
                    return response()->json(
                        [
                            'message' => 'Records restored successfully.',
                            'count' => 0,
                        ]
                    );
                    break;

                case 'Export':

                    return Excel::download(
                        new CyRunnerExport($request->ids),
                        'CyRunner-' . time() . '.xlsx'
                    );
                    return response()->json(['error' => "Sorry! Action not found."], 401);
                    break;

                default:

                    return response()->json(['error' => "Sorry! Action not found."], 401);
                    break;
            }
        } catch (Exception $e) {
            return response()->json(['error' => "Sorry! Action not found."], 401);
        }
    }

    function runScenario(Request $request){
        $manualRequest = new Request();
        $manualRequest->merge([
            'cy_runner_id' => $request->input('cy_runner_id')
        ]);
 
        $cypressController = new \App\Http\Controllers\Api\CypressController();
        $response = $cypressController->init($manualRequest);
        $view = view('panel.admin.cy-runners.include.scenario-output', compact('response'));
        return $view;
    }

    public function getGroupScenario(Request $request,$id)
    {
        
        try {
         
            $project = Project::find($id);
            $groupProject = Category::whereCategoryTypeId($id)->where('type_id', Category::STATUS_TYPE_CYPRESS)->get();
            $runners = CyRunner::whereProjectId($id)->where('status', "Active")->get();
            
            return view($this->viewPath . 'select',compact('project', 'runners', 'groupProject'))->render();
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function getGroupDragAndDropScenario(Request $request)
    {
        try {
         
            $project = Project::find($request->project_id);
            $groupProject = Category::whereId($request->group_id)->whereCategoryTypeId($request->project_id)->where('type_id', Category::STATUS_TYPE_CYPRESS)->first();
            $runners = CyRunner::whereProjectId($request->project_id)->where('group_id', $request->group_id)->where('status', "Active")->get();
           
          
            return view($this->viewPath . 'draganddrop', compact('project', 'runners', 'groupProject'))->render();
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function getBulkScenario(Request $request)
    {
        
        try {
            $project = Project::find($request->project_id);
            if ($request->group_id != null) {
                $runners = CyRunner::where('project_id', $request->project_id)
                                    ->where('group_id', $request->group_id)
                                    ->where('status', 'Active')
                                    ->get();
            
                                  
                $groupProject = Category::where('category_type_id', $request->project_id)
                                        ->where('id', $request->group_id)
                                        ->where('type_id', Category::STATUS_TYPE_CYPRESS)
                                        ->first(); 
                 $getAllGroup = "";
            } else {
                $runners = CyRunner::where('project_id', $request->project_id)
                ->where('status', 'Active')
                ->get();
                
                $groupProject = "";
                $getAllGroup =  Category::where('category_type_id', $request->project_id)->where('type_id', Category::STATUS_TYPE_CYPRESS)->get();                  
            }


            
            return view($this->viewPath . 'show',compact('project', 'runners', 'groupProject', 'getAllGroup'))->render();
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    function runBulkScenario(Request $request){
       if($request->project_id && $request->sequence){
             $cyRunner = CyRunner::where('project_id',$request->project_id)
            ->where('id',$request->sequence)
            ->first();


            $group = Category::where('category_type_id',$request->project_id)->where('id', $cyRunner->group_id)
             ->where('type_id', Category::STATUS_TYPE_APIRUNNER)->first();

            if($cyRunner){
                $manualRequest = new Request();
                $manualRequest->merge([ 
                    'cy_runner_id' => $cyRunner->id
                ]); 
                
                $cypressController = new \App\Http\Controllers\Api\CypressController();
                $response = $cypressController->init($manualRequest);
                $view = view('panel.admin.cy-runners.include.bulk-scenario-output', compact('response', 'group'))->render();
                return response([
                    'status' => 'success',
                    'view' => $view,
                    'sequence' => $cyRunner->id,
                ]);
            }else{
                return response([
                    'status' => 'error',
                    'msg' => 'Not Found!',
                ]);
            }
       }
    }

}
