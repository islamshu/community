<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(){
        return view('dashboard.members.index')->with('members',Member::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.members.create');
    }
    public function store(Request $request){
        $package = new Member();
        $package->title = $request->title;
        $package->save();
        return redirect()->route('members.index')->with(['success'=>'تم الاضافة بنجاح']);
    }
    public function edit($id){
        return view('dashboard.members.edit')->With('member',Member::find($id));
    }
    public function update(Request $request,$id){
        $package =  Member::find($id);
        $package->title = $request->title;
      
        $package->save();
        return redirect()->route('members.index')->with(['success'=>'تم التعديل بنجاح']);
    }
    public function destroy($id){
        $package = Member::find($id);
        $package->delete();
        return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
    }
}
