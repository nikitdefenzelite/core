<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202309-V1.3>
 * @link    <https://www.defenzelite.com>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public $label;

    function __construct()
    {
        $this->label = 'Categories';
    }
    public function index(CategoryRequest $request,$projectId)
    {
        $length = 5;
        if (request()->get('length')) {
            $length = $request->get('length');
        }
        if (!is_numeric($projectId)) {
            $projectId = secureToken($projectId, 'decrypt');
        }
        $categories = Category::query();
        if (request()->has('search') && request()->get('search')) {
            $categories->where('name', 'like', '%'.request()->get('search').'%');
        }

        if ($request->has('level')) {
            $level = $request->get('level');
        } else {
            $level = 1;
        }
        $nextLevel = $level + 1;
        if ($request->has('parent_id')) {
            $categories->where('category_type_id', $projectId)->where('level', $level)->where('parent_id', $request->get('parent_id'));
        } else {
            $categories->where('category_type_id', $projectId)->where('level', $level);
        }

        if ($request->get('trash') == 1) {
            $categories->onlyTrashed();
        }
        $categories = $categories->latest()->paginate($length);
        $categoryType = Project::where('id', $projectId)->first();
        $childCategory = Category::where('category_type_id', $projectId)->where('parent_id', null)->first();
        $label = $this->label;
        if ($request->ajax()) {
            return view('panel.admin.categories.load', ['categories' => $categories,'level' => $level,'projectId' => $projectId ,'nextLevel' => $nextLevel,'childCategory' => $childCategory,'label' => $label,'categoryType' => $categoryType])->render();
        }
     
        $statusLabels = [];
        foreach (Category::STATUS_TYPES as $statusType => $statusData) {
            $statusLabels[$statusType] = $statusData['label'];
        }


        return view('panel.admin.categories.index', compact('categories', 'level', 'projectId', 'categoryType', 'nextLevel', 'label', 'childCategory', 'statusLabels'));
    }

    public function print(Request $request)
    {
        $categories_arr = collect($request->records['data'])->pluck('id');
        $categories = Category::whereIn('id', $categories_arr)->latest()->get();
        return view('panel.admin.categories.print', ['categories' => $categories])->render();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create(Request $request) // $projectId, $level = 1, $parent_id = null
    // {
    //     $projectId = $request->projectId; 
    //     $categoryType = Project::where('id', $request->projectId)->first();
    //     $label = Str::singular($this->label);
    //     return view('panel.admin.categories.create', compact('projectId', 'categoryType', 'label'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {

        $text = trim($_POST['name']);
        $textAr = explode("\r\n", $text);
        $categoryNames = array_filter($textAr, 'trim');

        try {
            foreach ($categoryNames as $categoryName) {
                $category = new Category();
                $category->name = $categoryName;
                $category->level = $request->level;
                $category->category_type_id = $request->project_id;
                $category->type_id = $request->type_id;
                // $category->parent_id = $request->parent_id;
                // if ($request->hasFile('icon')) {
                //     $image = $request->file('icon');
                //     $path = storage_path('app/public/backend/category-icon');
                //     $imageName = 'category-icon' . $category->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                //     $image->move($path, $imageName);
                //     $category->icon=$imageName;
                // }
                $category->save();
            }
            if (request()->ajax()) {
                return response()->json(
                    [
                        'data' => $category,
                        'category_type_id' => $request->project_id,
                        'level' => $request->level,
                        'parent_id' => null,
                        'type_id' => $request->type_id,
                        'status'=>'success',
                        'message' => 'Success',
                        'title' => 'Category created successfully'
                    ]
                );
            }
            return redirect()->route('categories.index', [$request->project_id,'level' =>$request->level])->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryRequest $request, $id)
    {
        if (!is_numeric($id)) {
            $id = secureToken($id, 'decrypt');
        }
      
        $category = Category ::whereId($id)->firstOrFail();
        // $parent = Category::where('id', $category->parent_id)->first();
        $categoryType = Project::where('id', $category->category_type_id)->first();
        $categoryTypes = Project::get();
        $types = Category::TYPES;
        $parents = Category::where('level', '!=', 3)->get();
        $label = Str::singular($this->label);
        $statusLabels = [];
        foreach (Category::STATUS_TYPES as $statusType => $statusData) {
            $statusLabels[$statusType] = $statusData['label'];
        }

        return view('panel.admin.categories.edit', compact('category', 'categoryType', 'categoryTypes', 'types', 'parents', 'label', 'statusLabels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request $request
     * @param  \App\Models\Category       $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // if ($request->hasFile('icon')) {
        //     if ($category->icon != null) {
        //         unlinkFile(storage_path() . '/app/public/backend/category-icon', $category->icon);
        //     }
        //     $image = $request->file('icon');
        //     $path = storage_path('app/public/backend/category-icon');
        //     $imageName = 'category-icon' . $category->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
        //     $image->move($path, $imageName);
        //     $category->icon=$imageName;
        // }
            $category->name=$request->name;
            $category->level=$request->level;
            $category->category_type_id=$request->project_id;
            $category->type_id=$request->type_id;
            // $category->parent_id=$request->parent_id;
            $category->save();
            return redirect()->route('categories.index', [$request->project_id])->with('success', 'Category update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {

        try {
            if (!is_numeric($id)) {
                $id = secureToken($id, 'decrypt');
            }

            $category = Category::find($id);
            if ($category) {
                $category->delete();
                return back()->with('success', 'Category Deleted Successfully!');
            } else {
                return back()->with('error', 'Category not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function bulkAction(Category $category, CategoryRequest $request)
    {
        try {
            $html = [];

            $type = "success";
            if (!isset($request->ids)) {
                return response()->json(
                    [
                        'status'=>'error',
                    ]
                );
                return back()->with('error', 'Hands Up!","Atleast one row should be selected');
            }
            switch ($request->action) {
                // Delete
                case ('delete'):
                    Category::whereIn('id', $request->ids)->delete();
                    $msg = 'Bulk delete!';
                    $title = "Deleted ".count($request->ids)." records successfully!";
                    break;
                return back()->with('success', 'Category Type Deleted Successfully!');
            }

            if (request()->ajax()) {
                return response()->json(
                    [
                    'status'=>'success',
                    'column'=>$request->column,
                    'action'=>$request->action,
                    'data' => $request->ids,
                    'title' => $title,
                    'html' => $html,

                    ]
                );
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'There was an error: ' . $th->getMessage());
        }
    }
    public function moreAction(CategoryRequest $request)
    {
        if (!$request->has('ids') || count($request->ids) <= 0) {
            return response()->json(['error' => "Please select atleast one record."], 401);
        }
        try {
            switch (explode('-', $request->action)[0]) {
                // case 'status':
                //     $action = explode('-',$request->action)[1];
                //      Category::withTrashed()->whereIn('id', $request->ids)->each(function($q) use($action){
                //         $q->update(['status'=>trim($action)]);
                //     });
                //     return response()->json([
                //         'message' => 'Status changed successfully.',
                //     ]);
                //     break;  ;

                case 'Move To Trash':
                    Category::whereIn('id', $request->ids)->delete();
                    return response()->json([
                        'message' => 'Records moved to trashed successfully.',
                    ]);
                    break;

                case 'Delete Permanently':
                    for ($i=0; $i < count($request->ids); $i++) {
                        $category = Category::withTrashed()->find($request->ids[$i]);
                        $category->forceDelete();
                    }
                    return response()->json([
                        'message' => 'Records deleted permanently successfully.',
                    ]);
                    break;

                case 'Restore':
                    for ($i=0; $i < count($request->ids); $i++) {
                        $category = Category::withTrashed()->find($request->ids[$i]);
                        $category->restore();
                    }
                    return response()->json([
                        'message' => 'Records restored successfully.',
                    ]);
                    break;

                // case 'Export':

                //     return Excel::download(new CategoryExport($request->ids), 'category-'.time().'.csv');
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
