<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVideo;
use Illuminate\Http\Request;
use Validator;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function register_email(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:user_videos,email,NULL,id,date,'.today()->format('Y-m-d'),
            'date' => 'required|unique:user_videos,date,NULL,id,email,'.$request->input('email'),
        ]);
        

        // If validation fails, return the errors as JSON
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->first(),'status'=>'err'], 422);
        }
        $user = User::where('type','user')->where('email',$request->email)->first();
        if(!$user){
            $errors = [];
            array_push($errors,'البريد الاكتروني غير مسجل لدينا . يرجى تسجيل الدخول ');     

            return response()->json(['error' =>'لم يتم العثور على المستخدم','status'=>'er'], 422);

        }
        $user = new UserVideo();
        $user->name = $request->name;
        $user->date = today()->format('Y-m-d');
        $user->email = $request->email;
        $user->save();
        
        return response()->json(['success' => 'true'], 200);

        }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    public function video_setting(){
        return view('dashboard.setting');
    }
    public function setting(){
        return view('dashboard.setting_info');
    }

    
}
