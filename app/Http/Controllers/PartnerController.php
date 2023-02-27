<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(){
        return view('dashboard.partners.index')->with('partners',Partner::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.partners.create');
    }
    public function store(Request $request){
        // dd($request);
        $partner = new Partner();
        $partner->title = $request->title;
        $partner->image = $request->image->store('partners');
        $partner->url = $request->url;
        $partner->description = $request->description;
        $partner->save();
        return redirect()->route('partners.index')->with(['success'=>'تم اضافة الشريك بنجاح']);
    }
    public function edit($id){
        $partner = Partner::find($id);
        return view('dashboard.partners.edit')->with('partner',$partner);
    }
    public function update(Request $request,$id){
        $partner = Partner::find($id);
        $partner->title = $request->title;
        if($request->image != null){
            $partner->image = $request->image->store('partners');
        }
        $partner->url = $request->url;
        $partner->description = $request->description;
        $partner->save();
        return redirect()->route('partners.index')->with(['success'=>'تم تعديل الشريك بنجاح']);
    }
    public function destroy($id){
        $partner = Partner::find($id);
        $partner->delete();
        return redirect()->route('partners.index')->with(['success'=>'تم حذف الشريك بنجاح']);
    }
}
