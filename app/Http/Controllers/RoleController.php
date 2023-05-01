<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //     $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
    //     $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();


        $uiPermission = [];
        foreach($permission as $index => $permission)
        {
            $key = str_replace(['read', 'create', 'update', 'destroy'], [], strtolower($permission->name));
            $key = str_replace(['-', '_'], ' ', $key);
            $key = ucwords(trim($key));

            $uiPermission[$key][] = $permission;
        }
        // dd($uiPermission);
     
        return view('roles.create')->with('uiPermission',$uiPermission);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'display_name' => 'required|unique:roles,name',
            'permission_ids' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('display_name')]);
        $role->syncPermissions($request->input('permission_ids'));
        return redirect()->route('roles.index')
            ->with('success', 'تم الحفظ بنجاح');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        return view('roles.show', compact('role', 'rolePermissions'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $all_permissions = Permission::get();
        $uiPermission = [];
        foreach($all_permissions as $index => $permission)
        {
            $key = str_replace(['create', 'read', 'update', 'destroy'], [], strtolower($permission->name));
            $key = str_replace(['-', '_'], ' ', $key);
            $key = ucwords(trim($key));

            $uiPermission[$key][] = $permission;

        }

        return view('roles.edit', compact('role', 'all_permissions', 'uiPermission'));

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'display_name' => 'required|unique:roles,name,'.$id,
            'permission_ids' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->input('display_name');
        $role->save();
        $role->syncPermissions($request->input('permission_ids'));
        return redirect()->route('roles.index')
            ->with('success', 'تم التعديل بنجاح');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
