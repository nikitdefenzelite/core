<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ApiRunnerRequest;
use App\Models\ApiRunner;
use App\Models\Project;
use App\Models\Category;
use Exception;
use
    Maatwebsite\Excel\Facades\Excel;

class ApiRunnerController extends Controller
{
    protected $viewPath;
    protected $routePath;
    public $label;
    public function __construct()
    {
        $this->viewPath = 'panel.admin.api-runners.';
        $this->routePath = 'admin.api-runners.';
        $this->label = 'Api Runners';
    }
    /** * Display a listing of the resource. *
     * @return \Illuminate\Http\Response */ public function index(Request $request)
    {
        $length = 10;
        if (request()->get('length')
        ) {
            $length = $request->get('length');
        }
        $apiRunners = ApiRunner::query();

        if ($request->get('search')) {
            $apiRunners->where('title', 'like', '%' . $request->search . '%')->orWhere('id', 'like', '%' . $request->search . '%');
        }

        if ($request->get('from') && $request->get('to')) {
            $apiRunners->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d') . '
    00:00:00', \Carbon\Carbon::parse($request->to)->format('Y-m-d') . " 23:59:59"]);
        }

        if ($request->get('asc')) {
            $apiRunners->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $apiRunners->orderBy($request->get('desc'), 'desc');
        }
        if ($request->has('status') && $request->get('status') != null) {
            $apiRunners->where('status', $request->get('status'));
        }
        if ($request->has('category_id')) {
            $apiRunners->where('group_id', $request->get('category_id'));
        }
        if ($request->get('trash') == 1) {
            $apiRunners->onlyTrashed();
        }
        $project = null;
        if (request()->has('project_id') && request()->get('project_id')) {
            $project_id = request()->get('project_id');
            if (!is_numeric($project_id)) {
                $project_id = decrypt($project_id);
            }
            $project = Project::where('id', $project_id)->first();
            $apiRunners->where('project_id', $project_id);
        }
        $apiRunners = $apiRunners->latest();
        $apiRunners = $apiRunners->paginate($length);
        $label = $this->label;
        $bulkActivation = ApiRunner::BULK_ACTIVATION;
        if ($request->ajax()) {
            return view($this->viewPath . 'load', ['apiRunners' =>
            $apiRunners, 'bulkActivation' => $bulkActivation])->render();
        }

        return view($this->viewPath . 'index', compact('apiRunners', 'bulkActivation', 'label', 'project'));
    }

    public function print(Request $request)
    {
        $length = @$request->limit ?? 5000;
        $print_mode = true;
        $bulkActivation = ApiRunner::BULK_ACTIVATION;
        $apiRunners_arr = collect($request->records['data'])->pluck('id');
        $apiRunners = ApiRunner::whereIn('id', $apiRunners_arr)->paginate($length);
        return view(
            $this->viewPath . 'print',
            compact('apiRunners', 'bulkActivation', 'print_mode')
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
            $groups = Category::where('category_type_id', $project_id)->where('type_id', Category::STATUS_TYPE_APIRUNNER)->get();
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
    public function store(ApiRunnerRequest $request)
    {
        try {

            if (!is_numeric($request->project_id)) {
                $project_id = secureToken($request->project_id, 'decrypt');
            }
            $apiRunner = ApiRunner::create([
                'user_id' => $request->user_id,
                'project_id' => $project_id,
                'title' => $request->title,
                'status' => $request->status,
                'group_id' => $request->group_id,
                'code' => $request->code
            ]);


            if ($request->ajax())
                return response()->json([
                    'id' => $apiRunner->id,
                    'status' => 'success',
                    'message' => 'Success',
                    'title' => 'Record Created Successfully!'
                ]);
            else
                return redirect()->route($this->routePath . 'index')->with('success', 'Api Runner Created
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
            $apiRunner = ApiRunner::where('id', $id)->first();
            return view($this->viewPath . 'show', compact('apiRunner'));
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
            $apiRunner = ApiRunner::where('id', $id)->first();
            $groups = Category::where('category_type_id', $apiRunner->project_id)->where('type_id', Category::STATUS_TYPE_APIRUNNER)->get();
            return view($this->viewPath . 'edit', compact('apiRunner', 'groups'));
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
    public function update(ApiRunnerRequest $request, $id)
    {
        try {
            if (!is_numeric($id)) {
                $id = decrypt($id);
            }
            $apiRunner = ApiRunner::where('id', $id)->first();
            if ($apiRunner) {

                $chk = $apiRunner->update($request->all());

                if ($request->ajax())
                    return response()->json([
                        'id' => $apiRunner->id,
                        'status' => 'success',
                        'message' => 'Success',
                        'title' => 'Record Updated Successfully!'
                    ]);
                else
                    return redirect()->route($this->routePath . 'index')->with('success', 'Record Updated!');
            }
            return back()->with('error', 'Api Runner not found')->withInput($request->all());
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
            $apiRunner = ApiRunner::where('id', $id)->first();
            if ($apiRunner) {

                $apiRunner->delete();
                return back()->with('success', 'Api Runner deleted successfully');
            } else {
                return back()->with('error', 'Api Runner not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function restore($id)
    {
        try {
            $apiRunner = ApiRunner::withTrashed()->where('id', $id)->first();
            if ($apiRunner) {
                $apiRunner->restore();
                return back()->with('success', 'Api Runner restore successfully');
            } else {
                return back()->with('error', 'Api Runner not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    public function moreAction(ApiRunnerRequest $request)
    {
        if (!$request->has('ids') || count($request->ids) <= 0) {
            return response()->json(['error' => "Please select
            atleast one record."], 401);
        }
        try {
            switch (explode('-', $request->action)[0]) {
                case 'status':
                    $action = explode('-', $request->action)[1];
                    ApiRunner::withTrashed()->whereIn('id', $request->ids)->each(function ($q) use ($action) {
                        $q->update(['status' => trim($action)]);
                    });

                    return response()->json([
                        'message' => 'Status changed successfully.',
                        'count' => 0,
                    ]);
                    break;

                case 'Move To Trash':
                    ApiRunner::whereIn('id', $request->ids)->delete();
                    $count = ApiRunner::count();
                    return response()->json([
                        'message' => 'Records moved to trashed successfully.',
                        'count' => $count,
                    ]);
                    break;

                case 'Delete Permanently':

                    for ($i = 0; $i < count($request->ids); $i++) {
                        $apiRunner = ApiRunner::withTrashed()->find($request->ids[$i]);
                        $apiRunner->forceDelete();
                    }
                    return response()->json([
                        'message' => 'Records deleted permanently successfully.',
                    ]);
                    break;
                case 'Restore':
                    for ($i = 0; $i < count($request->ids); $i++) {
                        $apiRunner = ApiRunner::withTrashed()->find($request->ids[$i]);
                        $apiRunner->restore();
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
                        new ApiRunnerExport($request->ids),
                        'ApiRunner-' . time() . '.xlsx'
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

    function runScenario(Request $request)
    {

        $manualRequest = new Request();
        $manualRequest->merge([
            'api_runner_id' => $request->input('api_runner_id')
        ]);

        $cypressController = new \App\Http\Controllers\Api\ApiRunnerController();
        $response = $cypressController->run($manualRequest);
        $view = view('panel.admin.api-runners.include.scenario-output', compact('response'));
        return $view;
    }


    public function showImportProjectModal()
        {
            $projects = Project::all();
            return view('your_view_name', compact('projects'));
        }

    public function importPostmanCollection(Request $request)
        {
            // Validate incoming request
            // $request->validate([
            //     'project_id' => 'required|exists:projects,id'
            // ]);
            if (!is_numeric($request->project_id)) {
                $project_id = secureToken($request->project_id, 'decrypt');
            }
            
            $payload = [
                "project_repo_url" => $request->project_repo_url,
                "access_token" => $request->access_token,
                "api_key" => $request->api_key,
            ];
            
            $project = Project::where('id', $project_id)->first();
            
            $project = $project->update([
                'postman_payload' => $payload,
            ]);
            
            $manualRequest = new Request();
            $manualRequest->merge([
                'project_id' => $project_id,
                'api_key'=> $request->api_key,
                'directory_name' => $request->directory_name
            ]); 
                    
            $cypressController = new \App\Http\Controllers\Api\ApiRunnerController();
            $response = $cypressController->create($manualRequest);

            // Optionally, you can return a response
            return response()->json(['message' => 'Project created successfully', 'project' => $response]);
        }


    public function getGroupScenario(Request $request, $id)
    {
        try {

            $project = Project::find($id);
            $groupProject = Category::whereCategoryTypeId($id)->where('type_id', Category::STATUS_TYPE_APIRUNNER)->get();
            $runners = ApiRunner::whereProjectId($id)->where('status', "Active")->get();

            return view($this->viewPath . 'select', compact('project', 'runners', 'groupProject'))->render();
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    public function getGroupDragAndDropScenario(Request $request)
    {
        try {
            $project = Project::find($request->project_id);
            $groupProject = Category::whereId($request->group_id)->whereCategoryTypeId($request->project_id)->where('type_id', Category::STATUS_TYPE_APIRUNNER)->first();
            $runners = ApiRunner::whereProjectId($request->project_id)->where('group_id', $request->group_id)->where('status', "Active")->get();
          
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
                $runners = ApiRunner::where('project_id', $request->project_id)
                ->where('group_id', $request->group_id)
                ->where('status', 'Active')
                ->get();
                
               
                $groupProject = Category::where('category_type_id', $request->project_id)
                    ->where('id', $request->group_id)->where('type_id', Category::STATUS_TYPE_APIRUNNER)
                    ->first();
                $getAllGroup = "";
            } else {
                $runners = ApiRunner::where('project_id', $request->project_id)
                    ->where('status', 'Active')
                    ->get();

                $groupProject = "";
                $getAllGroup =  Category::where('category_type_id', $request->project_id)->where('type_id', Category::STATUS_TYPE_APIRUNNER)->get();
            }
           
            return view($this->viewPath . 'show', compact('project', 'runners', 'groupProject', 'getAllGroup'))->render();
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    function runBulkScenario(Request $request)
    {
        if ($request->project_id && $request->sequence) {
            $apiRunner = ApiRunner::where('project_id', $request->project_id)
                ->where('id', $request->sequence)
                ->first();

            $group = Category::where('category_type_id', $request->project_id)->where('id', $apiRunner->group_id)
                ->where('type_id', Category::STATUS_TYPE_APIRUNNER)->first();

            if ($apiRunner) {
                $manualRequest = new Request();
                $manualRequest->merge([
                    'api_runner_id' => $apiRunner->id
                ]);

                $cypressController = new \App\Http\Controllers\Api\ApiRunnerController();
                $response = $cypressController->run($manualRequest);
                $view = view('panel.admin.api-runners.include.bulk-scenario-output', compact('response', 'group'))->render();
                return response([
                    'status' => 'success',
                    'view' => $view,
                    'sequence' => $apiRunner->id,
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'msg' => 'Not Found!',
                ]);
            }
        }
    }
}
