<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202402-V2.0>
 * @link    <https://www.defenzelite.com>
 */

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public $label;

    function __construct()
    {
        $this->label = 'Roles';
    }
    public function index()
    {

        try {
            $groups = DB::table('permissions')
                ->select('group', DB::raw('GROUP_CONCAT(name) as permission_names'))
                ->groupBy('group')
            //    ->orderBy('permission_count', 'asc')
                ->get()
                ->toArray();
            $roles = Role::groupBy('name')->get();
            $label = $this->label;
            return view('panel.admin.roles.index', compact('groups', 'roles', 'label'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {

        try {
            $role = Role::create(
                [
                'name' => $request->role,
                'display_name' => $request->display_name,
                'description' => $request->description,
                ]
            );
            if ($request->has('permissions') && $request->has('permissions') != null) {
                $role->syncPermissions($request->permissions);
            }

            if ($role) {
                return back()->with('success', 'Role created successfully!');
            } else {
                return back()->with('error', 'Failed to create role! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            $label = Str::singular($this->label);
            return redirect()->back()->with('error', $bug, compact('label'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!is_numeric($id)) {
            $id = secureToken($id, 'decrypt');
        }
          $role = Role::find($id);
        if ($role) {
            $role_permission = $role->permissions()->pluck('id')->toArray();
            $allPermissions = DB::table('permissions')
                ->select('group', DB::raw('GROUP_CONCAT(id) as permission_ids'), DB::raw('GROUP_CONCAT(name) as permission_names'))
                ->groupBy('group')
                ->get()
                ->toArray();
            $label = $this->label;
            return view('panel.admin.roles.edit', compact('role', 'role_permission', 'allPermissions', 'label'));
        } else {
            return redirect('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        return 's';
        try {
            // return $request->permissions;
            $role = Role::find($id);
            $role->update(
                [
                    'name' => $request->role,
                    'display_name' => $request->display_name,
                    'description' => $request->description,
                ]
            );

            if ($request->has('permissions') && is_array($request->permissions)) {
                // Assuming $request->permissions is an array of permission IDs
                $role->syncPermissions($request->permissions);
            } elseif ($request->permissions === null) {
                // If $request->permissions is null, detach all current permissions
                $role->detachPermissions($role->permissions->pluck('id')->toArray());
            }

            return redirect()->route('panel.admin.roles.index')->with('success', 'Role info updated Successfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role) {
            $role->delete();
            $role->detachPermissions($role->permissions->pluck('name'));
            return back()->with('success', 'Role deleted!');
        } else {
            return redirect('404');
        }
    }
}
