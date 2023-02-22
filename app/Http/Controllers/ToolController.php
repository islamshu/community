<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\ToolLink;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(){
        return view('dashboard.tools.index')->with('tools',Tool::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.tools.create');
    }
    public function store(Request $request){
        $tool = new Tool();
        $tool->title = $request->title;
        $tool->image = $request->image->store('tools');
        $tool->description = $request->description;
        $tool->save();
        foreach ($request->moreFields as $key => $value) {
            $link = new ToolLink();
            $link->tool_id = $tool->id;
            $link->url = $value['url'];
            $link->type = $value['type'];
            $link->save();
         }
         return redirect()->route('tools.index')->with(['success'=>'تم اضافة الاداة بنجاح']);

    }
    public function edit($id){
        $tool = Tool::find($id);
        return view('dashboard.tools.edit')->with('count',$tool->links->count()+1)->with('tool',$tool);
    }
    public function update(Request $request,$id){
        $tool = Tool::find($id);
        $tool->title = $request->title;
        if($request->image != null){
            $tool->image = $request->image->store('tools');
        }
        $tool->description = $request->description;
        $tool->save();
        ToolLink::where('tool_id',$tool->id)->delete();

        foreach ($request->moreFields as $key => $value) {
            if($value['url'] == null || $value['type'] == null){
                continue;
              }            $link = new ToolLink();
            $link->tool_id = $tool->id;
            $link->url = $value['url'];
            $link->type = $value['type'];
            $link->save();
         }
         return redirect()->route('tools.index')->with(['success'=>'تم تعديل الاداة بنجاح']);
    }
    public function destroy($id)
    {
        $tool = Tool::find($id);
        $tool->delete();
        return redirect()->route('tools.index')->with(['success'=>'تم حذف الاداة بنجاح']);

    }
}
