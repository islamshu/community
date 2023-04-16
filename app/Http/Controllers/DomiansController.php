<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Domians;
use Illuminate\Http\Request;

class DomiansController extends Controller
{
    public function index()
    {
        return view('dashboard.domian.index')->with('domians', Domians::orderby('id', 'desc')->get());
    }
    public function create()
    {
        return view('dashboard.domian.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $domian = new Domians();
        $domian->title = $request->title;
        $domian->save();
       

        return redirect()->route('domians.index')->with(['success'=>'تم اضافة المجال بنجاح']);
    }
    public function edit($id){
        return view('dashboard.domian.edit')->with('domian',Domians::find($id));
    }
    public function update(Request $request,$id)
    {

        $request->validate([
            'title' => 'required',
        ]);
        $domian = Domians::find($id);
        $domian->title = $request->title;
        $domian->save();
       
        return redirect()->route('domians.index')->with(['success'=>'تم تعديل المجال بنجاح']);
    }
    public function destroy($id){
        Domians::find($id)->delete();

        return redirect()->route('domians.index')->with(['success'=>'تم حذف المجال بنجاح']);
    }
}
