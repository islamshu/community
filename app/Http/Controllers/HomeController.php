<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\AlertSubscribe;
use App\Mail\WelcomRgister;
use App\Models\Admin;
use App\Models\User;
use App\Models\UserVideo;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function get_users(){
        $now = today();
        $threeDaysFromNow = $now->addDays(3);
        $sub_day = str_replace('00:00:00','',$threeDaysFromNow);
        $users = User::where('is_paid',1)->where('end_at', $threeDaysFromNow)->get();
        foreach($users as $user){
            $date_send = [
                'id' => $user->id,
                'name' => $user->name,
                'url' => '',
                'title' => 'سينتهي الاشتراك بعد ثلاث ايام !',
                'time' => $user->updated_at
            ];
            $user->notify(new GeneralNotification($date_send));
            $message =" نريد تنبيهك الى ان الاشتراك الخاص بك في مجتمعنا سينتهي في تاريخ   "  . $sub_day;
            // dd($message);
            Mail::to($user->email)->send(new AlertSubscribe($user->name,$user->email, $threeDaysFromNow,($message)));
        }
        return $users;
    }
    public function login_admin(){
        return view('dashboard.auth.login');
    }
    public function profile(){
        $user = Admin::first();
        return view('dashboard.auth.profile')->with('user',$user);
    }
    public function update_profile(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email'
        ]);
        if($request->password != null){
            $request->validate([
                'password'=>'required',
                'confirm-password'=>'required|same:password'
            ]);
        }
        $admin = Admin::first();
        $admin->name = $request->name;
        $admin->email = $request->email;
        if($request->password != null){
            $admin->password =bcrypt( $request->password);
        }
        $admin->save();
        return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);

    }
    public function post_login_admin(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }
        return redirect()->back()->with(['error'=>'البريد الاكتروني او كلمة المرور غير صحيحة']);

    }
    public function logout(){
        auth('admin')->logout();
        return redirect()->route('login_admin');
    }
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
               

            return response()->json(['error' =>'البريد الاكتروني غير مسجل لدينا . يرجى تسجيل الدخول ','status'=>'er'], 422);

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
    public function meeting_setting(){
        return view('dashboard.meeting_setting');
    }

    
    public function setting(){
        return view('dashboard.setting_info');
    }

    
}
