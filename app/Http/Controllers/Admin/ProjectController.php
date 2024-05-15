<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use App\Models\ApiRunner;
use App\Models\CyRunner;
use GuzzleHttp\Client;
use Exception;
use
    Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    protected $viewPath;
    protected $routePath;
    public $label;
    public function __construct()
    {
        $this->viewPath = 'panel.admin.projects.';
        $this->routePath = 'admin.projects.';
        $this->label = 'Projects';
    }
    /** * Display a listing of the resource. *
     * @return \Illuminate\Http\Response */
    public function index(Request $request)
    {
        $length = 10;
        if (request()->get('length')) {
            $length = $request->get('length');
        }
        $projects = Project::query();

        if ($request->get('search')) {
            $projects->where('id', 'like', '%' . $request->search . '%')->orWhere('name', 'like', '%' . $request->search . '%');
        }

        if ($request->get('from') && $request->get('to')) {
            $projects->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d') . '
    00:00:00', \Carbon\Carbon::parse($request->to)->format('Y-m-d') . " 23:59:59"]);
        }

        if ($request->get('asc')) {
            $projects->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $projects->orderBy($request->get('desc'), 'desc');
        }
        if ($request->get('trash') == 1) {
            $projects->onlyTrashed();
        }
        $projects = $projects->paginate($length);
        $label = $this->label;
        $bulkActivation = Project::BULK_ACTIVATION;
        if ($request->ajax()) {
            return view($this->viewPath . 'load', ['projects' =>
            $projects, 'bulkActivation' => $bulkActivation])->render();
        }

        return view($this->viewPath . 'index', compact('projects', 'bulkActivation', 'label'));
    }

    public function print(Request $request)
    {
        $length = @$request->limit ?? 5000;
        $print_mode = true;
        $bulkActivation = Project::BULK_ACTIVATION;
        $projects_arr = collect($request->records['data'])->pluck('id');
        $projects = Project::whereIn('id', $projects_arr)->paginate($length);
        return view(
            $this->viewPath . 'print',
            compact('projects', 'bulkActivation', 'print_mode')
        )->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view($this->viewPath . 'create');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }




    public function storeTask(Request $request, $id)
    {
        try {
            $project = Project::find($id);
            $this->errorTaskCreate($project->project_register_id, $request->error_msg, $request->request_link);
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }



    public function errorTaskCreate($project_register_id, $error_msg, $request_link)
    {
        $client = new Client();

        $headers = [
            'Accept' => 'application/json',
        ];

        $options = [
            'multipart' => [
                [
                    'name' => 'project_register_id',
                    'contents' => $project_register_id,
                ],
                [
                    'name' => 'error_msg',
                    'contents' => $error_msg,
                ],
                [
                    'name' => 'request_link',
                    'contents' => $request_link,
                ],
            ],
            'verify' => false, // Enable SSL certificate verification
        ];

        $response = $client->post('https://hq.defenzelite.com/api/v1/task/add-exception', [
            'headers' => $headers,
            'multipart' => $options['multipart'],
            'verify' => false,
        ]);

        // Check if the request was successful
        if ($response->getStatusCode() == 200) {
            // Request was successful
            return true;
        } else {
            // Request failed, handle the error
            return false;
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        try {
            $project = Project::create($request->all());

            if ($request->ajax())
                return response()->json([
                    'id' => $project->id,
                    'status' => 'success',
                    'message' => 'Success',
                    'title' => 'Record Created Successfully!'
                ]);
            else
                return redirect()->route($this->routePath . 'index')->with('success', 'Project Created
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
            $project = Project::where('id', $id)->first();
            return view($this->viewPath . 'show', compact('project'));
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
            $project = Project::where('id', $id)->first();
            return view($this->viewPath . 'edit', compact('project'));
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
    public function update(ProjectRequest $request, $id)
    {
        try {
            if (!is_numeric($id)) {
                $id = decrypt($id);
            }
            $project = Project::where('id', $id)->first();
            if ($project) {

                $chk = $project->update($request->all());

                if ($request->ajax())
                    return response()->json([
                        'id' => $project->id,
                        'status' => 'success',
                        'message' => 'Success',
                        'title' => 'Record Updated Successfully!'
                    ]);
                else
                    return redirect()->route($this->routePath . 'index')->with('success', 'Record Updated!');
            }
            return back()->with('error', 'Project not found')->withInput($request->all());
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
            $project = Project::where('id', $id)->first();
            if ($project) {

                $project->delete();
                return back()->with('success', 'Project deleted successfully');
            } else {
                return back()->with('error', 'Project not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function restore($id)
    {
        try {
            $project = Project::withTrashed()->where('id', $id)->first();
            if ($project) {
                $project->restore();
                return back()->with('success', 'Project restore successfully');
            } else {
                return back()->with('error', 'Project not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    public function moreAction(ProjectRequest $request)
    {
        if (!$request->has('ids') || count($request->ids) <= 0) {
            return response()->json(['error' => "Please select
            atleast one record."], 401);
        }
        try {
            switch (explode('-', $request->action)[0]) {

                case 'Move To Trash':
                    Project::whereIn('id', $request->ids)->delete();
                    $count = Project::count();
                    return response()->json([
                        'message' => 'Records moved to trashed successfully.',
                        'count' => $count,
                    ]);
                    break;

                case 'Delete Permanently':

                    for ($i = 0; $i < count($request->ids); $i++) {
                        $project = Project::withTrashed()->find($request->ids[$i]);
                        $project->forceDelete();
                    }
                    return response()->json([
                        'message' => 'Records deleted permanently successfully.',
                    ]);
                    break;
                case 'Restore':
                    for ($i = 0; $i < count($request->ids); $i++) {
                        $project = Project::withTrashed()->find($request->ids[$i]);
                        $project->restore();
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
                        new ProjectExport($request->ids),
                        'Project-' . time() . '.xlsx'
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

    //upload task upload

    public function uploadTask(Request $request)
    {
        $client = new Client();

        $headers = [
            'Accept' => 'application/json',
        ];

        $data = [
            'project_register_id' => $request->project_id,
            'error_msg' => $request->task_description,
            'request_link' => '#'
        ];

        $apiUrl = 'https://hq.defenzelite.com/api/v1/task/add-exception';
        $response = $this->postContentByCurl($apiUrl, $data, $headers);

        if ($response && isset($response['status']) && $response['status'] === 'success') {
            return response()->json([
                'status' => 'success',
                'message' => 'Success',
                'title' => 'Task Uploaded Successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Error',
                'title' => 'Failed to add task!'
            ]);
        }
    }


    public function postContentByCurl($apiUrl, $data, $headers)
    {
        $ch = curl_init($apiUrl);
        $payload = json_encode($data);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Disable SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        if ($result === false) {
            // Handle cURL error
            return ['success' => false, 'error' => curl_error($ch)];
        }

        curl_close($ch);
        $response = json_decode($result, true);
        return $response;
    }
}
