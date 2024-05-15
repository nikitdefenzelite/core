<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ApiRunnerLogRequest;
use App\Models\ApiRunnerLog;
use Exception;
use
    Maatwebsite\Excel\Facades\Excel;

class ApiRunnerLogController extends Controller
{
    protected $viewPath;
    protected $routePath;
    public $label;
    public function __construct()
    {
        $this->viewPath = 'panel.admin.api-runner-logs.';
        $this->routePath = 'admin.api-runner-logs.';
        $this->label = 'Api Runner Logs';
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
        $apiRunnerLogs = ApiRunnerLog::query();

        if ($request->get('search')) {
            $apiRunnerLogs->where('id', 'like', '%' . $request->search . '%');
        }

        if ($request->get('from') && $request->get('to')) {
            $apiRunnerLogs->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d') . '
            00:00:00', \Carbon\Carbon::parse($request->to)->format('Y-m-d') . " 23:59:59"]);
        }

        if ($request->get('asc')) {
            $apiRunnerLogs->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $apiRunnerLogs->orderBy($request->get('desc'), 'desc');
        }
        if ($request->get('trash') == 1) {
            $apiRunnerLogs->onlyTrashed();
        }
        $apiRunnerLogs = $apiRunnerLogs->latest();
        $apiRunnerLogs = $apiRunnerLogs->paginate($length);
        
        $label = $this->label;
        $bulkActivation = ApiRunnerLog::BULK_ACTIVATION;
        if ($request->ajax()) {
            return view($this->viewPath . 'load', ['apiRunnerLogs' =>
            $apiRunnerLogs, 'bulkActivation' => $bulkActivation])->render();
        }

        return view($this->viewPath . 'index', compact('apiRunnerLogs', 'bulkActivation', 'label'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiRunnerLogRequest $request)
    {
        try {
            $cyRunnerLog = ApiRunnerLog::create($request->all());


            if ($request->ajax())
                return response()->json([
                    'id' => $cyRunnerLog->id,
                    'status' => 'success',
                    'message' => 'Success',
                    'title' => 'Record Created Successfully!'
                ]);
            else
                return redirect()->route($this->routePath . 'index')->with('success', 'Cy Runner Log Created
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
            $cyRunnerLog = ApiRunnerLog::where('id', $id)->first();
            return view($this->viewPath . 'show', compact('cyRunnerLog'));
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
            $cyRunnerLog = ApiRunnerLog::where('id', $id)->first();
            return view($this->viewPath . 'edit', compact('cyRunnerLog'));
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
    public function update(ApiRunnerLogRequest $request, $id)
    {
        try {
            if (!is_numeric($id)) {
                $id = decrypt($id);
            }
            $cyRunnerLog = ApiRunnerLog::where('id', $id)->first();
            if ($cyRunnerLog) {

                $chk = $cyRunnerLog->update($request->all());

                if ($request->ajax())
                    return response()->json([
                        'id' => $cyRunnerLog->id,
                        'status' => 'success',
                        'message' => 'Success',
                        'title' => 'Record Updated Successfully!'
                    ]);
                else
                    return redirect()->route($this->routePath . 'index')->with('success', 'Record Updated!');
            }
            return back()->with('error', 'Cy Runner Log not found')->withInput($request->all());
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
            $cyRunnerLog = CyRunnerLog::where('id', $id)->first();
            if ($cyRunnerLog) {

                $cyRunnerLog->delete();
                return back()->with('success', 'Cy Runner Log deleted successfully');
            } else {
                return back()->with('error', 'Cy Runner Log not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
   
    public function moreAction(ApiRunnerLogRequest $request)
    {
        if (!$request->has('ids') || count($request->ids) <= 0) {
            return response()->json(['error' => "Please select
            atleast one record."], 401);
        }
        try {
            switch (explode('-', $request->action)[0]) {
                case 'status':
                    $action = explode('-', $request->action)[1];
                    CyRunnerLog::withTrashed()->whereIn('id', $request->ids)->each(function ($q) use ($action) {
                        $q->update(['status' => trim($action)]);
                    });

                    return response()->json([
                        'message' => 'Status changed successfully.',
                        'count' => 0,
                    ]);
                    break;
                case 'result':
                    $action = explode('-', $request->action)[1];
                    CyRunnerLog::withTrashed()->whereIn('id', $request->ids)->each(function ($q) use ($action) {
                        $q->update(['result' => trim($action)]);
                    });

                    return response()->json([
                        'message' => 'Result changed successfully.',
                        'count' => 0,
                    ]);
                    break;

                case 'Move To Trash':
                    CyRunnerLog::whereIn('id', $request->ids)->delete();
                    $count = CyRunnerLog::count();
                    return response()->json([
                        'message' => 'Records moved to trashed successfully.',
                        'count' => $count,
                    ]);
                    break;

                case 'Delete Permanently':

                    for ($i = 0; $i < count($request->ids); $i++) {
                        $cyRunnerLog = CyRunnerLog::withTrashed()->find($request->ids[$i]);
                        $cyRunnerLog->forceDelete();
                    }
                    return response()->json([
                        'message' => 'Records deleted permanently successfully.',
                    ]);
                    break;
                case 'Restore':
                    for ($i = 0; $i < count($request->ids); $i++) {
                        $cyRunnerLog = CyRunnerLog::withTrashed()->find($request->ids[$i]);
                        $cyRunnerLog->restore();
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
                        new CyRunnerLogExport($request->ids),
                        'CyRunnerLog-' . time() . '.xlsx'
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
}
