<?php
/**
 *
 * @category zStarter
 *
 * @ref Defenzelite product
 * @author <Defenzelite  hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 1.2.0>
 * @link <https://www.defenzelite.com>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryTypeRequest;
use App\Models\CategoryType;
use App\Models\Category;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryTypeController extends Controller
{
    public $label;

    function __construct()
    {
        $this->label = 'Category Groups';
    }

    public function index(Request $request)
    {
        return "d";
        $length = 10;
        if (request()->get('length')) {
            $length = $request->get('length');
        }
        $categoryTypes = CategoryType::query();


        if (request()->has('search') && request()->get('search')) {
            $categoryTypes->where('name', 'like', '%' . request()->get('search') . '%')
                ->orWhere('code', 'like', '%' . $request->search . '%');
        }
        if ($request->get('asc')) {
            $categoryTypes->orderBy($request->get('asc'), 'asc');
        }
        if ($request->get('desc')) {
            $categoryTypes->orderBy($request->get('desc'), 'desc');
        }
        if ($request->get('trash') == 1) {
            $categoryTypes->onlyTrashed();
        }
        $categoryTypes = $categoryTypes->latest()->paginate($length);

        if ($request->ajax()) {
            return view('panel.admin.category-types.load', ['categoryTypes' => $categoryTypes])->render();
        }
        $label = $this->label;
        return view('panel.admin.category-types.index', compact('categoryTypes', 'label'));
    }

    public function print(Request $request)
    {
        $categoryTypes_arr = collect($request->records['data'])->pluck('id');
        $categoryTypes = CategoryType::whereIn('id', $categoryTypes_arr)->latest()->get();
        return view('panel.admin.category-types.print', ['categoryTypes' => $categoryTypes])->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $permissions = Permission::get();
        $label = Str::singular($this->label);
        return view('panel.admin.category-types.create', compact('permissions', 'label'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryTypeRequest $request)
    {

        try {
            $data = new CategoryType();
            $data->name = $request->name;
            $data->code = $request->code;
            $data->is_permanent = $request->is_permanent;
            $data->allowed_level = $request->allowed_level;
            $data->remark = $request->remark;
            $data->save();
            if (request()->ajax()) {
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'Success',
                        'title' => 'Category Group created successfully'
                    ]
                );
            }
            return redirect(route('panel.admin.category-types.index'))->with('success', 'Category Group created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CategoryType $categoryType
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryType $categoryType, $id)
    {
        if (!is_numeric($id)) {
            $id = secureToken($id, 'decrypt');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CategoryType $categoryType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (!is_numeric($id)) {
            $id = secureToken($id, 'decrypt');
        }
        $categoryType = CategoryType::whereId($id)->first();
        $permissions = Permission::get();
        $label = Str::singular($this->label);
        return view('panel.admin.category-types.edit', compact('categoryType', 'permissions', 'label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Request $request
     * @param \App\Models\CategoryType $categoryType
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryTypeRequest $request, CategoryType $categoryType)
    {
        try {
            //  return $request->all();
            $categoryType->name = $request->name;
//            $categoryType->allowed_level = $request->allowed_level;

            // $categoryType->code=$request->code;
            // $categoryType->permission_id=$request->permission_id;
            $categoryType->remark = $request->remark;
            $categoryType->save();
            if (request()->ajax()) {
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'Success',
                        'title' => 'Record Updated Successfully'
                    ]
                );
            }
            return redirect()->route('panel.admin.category-types.index')->with('success', 'Category Group update successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CategoryType $categoryType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryType $categoryType, $id)
    {
        try {
            if (!is_numeric($id)) {
                $id = secureToken($id, 'decrypt');
            }
            $categoryType = CategoryType::find($id);
            if ($categoryType) {
                Category::where('id', $categoryType->id)->delete();
                $categoryType->delete();
                return back()->with('success', 'Category Type Deleted Successfully!');
            } else {
                return back()->with('error', 'Category Type not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function bulkAction(CategoryType $categoryType, Request $request)
    {
        try {
            $ids = explode(',', $request->ids);
            foreach ($ids as $id) {
                if ($id != null) {
                    CategoryType::where('id', $id)->delete();
                    Category::where('category_id', $id)->delete();
                }
            }
            if ($ids == [""]) {
                return back()->with('error', 'There were no rows selected by you!');
            } else {
                if (request()->ajax()) {
                    return response()->json(
                        [
                            'status' => 'success',
                            'message' => 'Success',
                            'title' => 'Category Group Deleted Successfully!'
                        ]
                    );
                }
                return back()->with('success', 'Category Group Deleted Successfully!');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function moreAction(CategoryTypeRequest $request)
    {
        if (!$request->has('ids') || count($request->ids) <= 0) {
            return response()->json(['error' => "Please select atleast one record."], 401);
        }
        try {
            switch (explode('-', $request->action)[0]) {
                // case 'status':
                //     $action = explode('-',$request->action)[1];
                //      CategoryType::withTrashed()->whereIn('id', $request->ids)->each(function($q) use($action){
                //         $q->update(['status'=>trim($action)]);
                //     });
                //     return response()->json([
                //         'message' => 'Status changed successfully.',
                //     ]);
                //     break;  ;

                case 'Move To Trash':
                    CategoryType::whereIn('id', $request->ids)->delete();
                    return response()->json([
                        'message' => 'Records moved to trashed successfully.',
                    ]);
                    break;

                case 'Delete Permanently':
                    for ($i = 0; $i < count($request->ids); $i++) {
                        $categorytype = CategoryType::withTrashed()->find($request->ids[$i]);
                        $categorytype->forceDelete();
                    }
                    return response()->json([
                        'message' => 'Records deleted permanently successfully.',
                    ]);
                    break;

                case 'Restore':
                    for ($i = 0; $i < count($request->ids); $i++) {
                        $categorytype = CategoryType::withTrashed()->find($request->ids[$i]);
                        $categorytype->restore();
                    }
                    return response()->json([
                        'message' => 'Records restored successfully.',
                    ]);
                    break;

                // case 'Export':

                //     return Excel::download(new CategoryTypeExport($request->ids), 'categorytype-'.time().'.csv');
                //     return response()->json(['error' => "Sorry! Action not found."], 401);
                //     break;

                default:
                    return response()->json(['error' => "Sorry! Action not found."], 401);
                    break;
            }
        } catch (Exception $e) {
            return response()->json(['error' => "Sorry! Action not found."], 401);
        }
    }
}
