<?php

namespace App\Http\Controllers;

use App\Models\UserVideo;
use Illuminate\Http\Request;

class UserVideosController extends Controller
{
    public function index(){
        $users = UserVideo::orderby('id','desc')->get();
        return view('dashboard.userVideos.index')->with('users',$users);
    }
    public function destroy($id){
        $users = UserVideo::find($id);
        return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
    }
}
