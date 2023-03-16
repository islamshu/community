<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(){
        return view('dashboard.packages.index')->with('packages',Package::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.packages.create');
    }
    public function store(Request $request){
        $package = new Package();
        $package->title = $request->title;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->period = $request->period;
        $package->image = $request->image->store('packages');
        $package->save();
        return redirect()->route('packages.index')->with(['success'=>'تم الاضافة بنجاح']);
    }
    public function edit($id){
        return view('dashboard.packages.edit')->With('package',Package::find($id));
    }
    public function update(Request $request,$id){
        $package =  Package::find($id);
        $package->title = $request->title;
        $package->price = $request->price;
        $package->period = $request->period;
        $package->description = $request->description;
        if($request->image != null){
            $package->image = $request->image->store('packages');
        }
        $package->save();
        return redirect()->route('packages.index')->with(['success'=>'تم التعديل بنجاح']);
    }
    public function destroy($id){
        $package = Package::find($id);
        
        $package->delete();
        return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
    }
}
