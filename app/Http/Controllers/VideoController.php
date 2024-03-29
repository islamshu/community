<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\User;
use App\Models\UserVideo;
use App\Models\Video;
use App\Models\VideoUser;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(){
        return view('dashboard.videos.index')->with('videos',Video::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.videos.create')->with('communities',Community::get());
    }
    public function store(Request $request){
        $video = new Video();
        $video->title = $request->title;
        $video->description = $request->description;
        $video->type = $request->type;
        $video->date = $request->date;
        $date = $request->date ;
        $date_strtok = strtok($date,'T');
        $video->community_id = $request->community_id;
        // $uss = UserVideo::where('date',$date_strtok)->count();
        $video->num_guest = $request->num_guest;
        // if($uss == null ){
        //     return redirect()->back()->with(['error'=>'لا يوجد مستخدمين لهذه الجلسة']);
        // }
        $video->images = $request->image->store('imagesVideo');
        if($request->video != null){
            $video->file = $request->video->store('videos');
        }
        $video->url = $request->url;
        $video->save();
        if($request->users != null){
            foreach($request->users as $d){
                $user = new VideoUser();
                $user->video_id = $video->id;
                $user->user_id = $d;
                $user->save();
            }
        }
        return redirect()->route('videos.index')->with(['success'=>'تم اضافة الجلسة بنجاح']);
    }
    public function videos_update_status(Request $request){
        $video = Video::find($request->video_id);
        $video->in_home = $request->status;
        $video->save();
    }
    public function get_user_video(Request $request){
        $date = $request->date ;
        $date_strtok = strtok($date,'T');
        $uss = UserVideo::where('date',$date_strtok)->count();
        return response()->json($uss);
        
        

    }
    public function edit($id){
        $video = Video::find($id);
        $users =[];
        foreach($video->users as $user){
            array_push($users,$user->user_id);
        }
        $date_strtok = strtok($video->date,' ');

        $uss = UserVideo::select('email')->where('date',$date_strtok)->get();
        $userss = User::whereIn('email',$uss)->get();
        
        return view('dashboard.videos.edit')->with('video',$video)->with('users',$users)->with('userss',$userss)->with('communities',Community::get());
    }
    public function update(Request $request , $id){
        $request->validate([
            'url'=>$request->type == 'url' ?'required' : '',

        ]);
        $video =  Video::find($id);
        $video->title = $request->title;
        $video->description = $request->description;
        $video->type = $request->type;
        $video->date = $request->date;
        $video->community_id = $request->community_id;
        $video->num_guest = $request->num_guest;
        if($request->image != null){
            $video->images = $request->image->store('imagesVideo');
        }
        if($request->file != null){
            $video->file = $request->video->store('videos');
        }
        $video->url = $request->url;
        $video->save();
        // $video->users->delete();
        VideoUser::where('video_id',$video->id)->delete();
        if($request->users != null){
            foreach($request->users as $d){
                $user = new VideoUser();
                $user->video_id = $video->id;
                $user->user_id = $d;
                $user->save();
            }
        }
        return redirect()->route('videos.index')->with(['success'=>'تم تعديل الجلسة بنجاح']);
    }
    public function destroy($id){
        $video =  Video::find($id);
        $video->delete();
        return redirect()->route('videos.index')->with(['success'=>'تم حذف الجلسة بنجاح']);
    }
}
