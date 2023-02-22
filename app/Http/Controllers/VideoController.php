<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(){
        return view('dashboard.videos.index')->with('videos',Video::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.videos.create');
    }
    public function store(Request $request){
        $video = new Video();
        $video->title = $request->title;
        $video->description = $request->description;
        $video->type = $request->type;
        if($request->video != null){
            $video->file = $request->video->store('videos');
        }
        $video->url = $request->url;
        $video->save();
        return redirect()->route('videos.index')->with(['success'=>'تم اضافة الجلسة بنجاح']);
    }
    public function edit($id){
        return view('dashboard.videos.edit')->with('video',Video::find($id));
    }
    public function update(Request $request , $id){
        $request->validate([
            'url'=>$request->type == 'url' ?'required' : '',

        ]);
        $video =  Video::find($id);
        $video->title = $request->title;
        $video->description = $request->description;
        $video->type = $request->type;
        if($request->file != null){
            $video->file = $request->video->store('videos');
        }
        $video->url = $request->url;
        $video->save();
        return redirect()->route('videos.index')->with(['success'=>'تم تعديل الجلسة بنجاح']);
    }
    public function destroy($id){
        $video =  Video::find($id);
        $video->delete();
        return redirect()->route('videos.index')->with(['success'=>'تم حذف الجلسة بنجاح']);
    }
}
