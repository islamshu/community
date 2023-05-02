<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(){
        return view('dashboard.admins.index')->with('admins',Admin::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.admins.create')->with('roles',Role::get());
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:admins',
            'password'=>'required',
            'role'=>'required'
        ]);
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->added_by=auth('admin')->id();
        $admin->save();
        $admin->syncRoles($request->input('role'));
        return redirect()->route('admins.index')->with(['success'=>'تم الاضافة بنجاح']);
    }
    public function edit($id){
        return view('dashboard.admins.edit')->with('admin',Admin::find($id))->with('roles',Role::get());
    }
    public function update(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:admins,email,'.$id,
            'role'=>'required'
        ]);
        $admin = Admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        if($request->password){
            $admin->password = bcrypt($request->password);
        }
        $admin->save();
        // dd('f');
        $admin->syncRoles($request->input('role'));
        return redirect()->route('admins.index')->with(['success'=>'تم التعديل بنجاح']);
    }
}
