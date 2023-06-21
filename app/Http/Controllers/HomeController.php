<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\AlertSubscribe;
use App\Mail\WelcomRgister;
use App\Models\Admin;
use App\Models\DiscountCode;
use App\Models\Package;
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
    public function get_discount_code(Request $request){
        $pakge = Package::find($request->packge_id);
        $code = DiscountCode::where('code',$request->discount_code)->first();
        if($code){
            $type = $code->discount_type;
            if($type == 'fixed'){
                return response()->json(['success'=>true,'price' => $pakge->price - $code->discount_value]);
            }else{
                $price = $pakge->price;
                $discount_price = $price * ($code->discount_value/ 100);
                $pricee = $price -$discount_price; 
                return response()->json(['success'=>true,'price' => $pricee]);
            }
        }else{
            return response()->json(['success'=>false,'price' => $pakge->price]);
    
        }
    }
    public function get_price_for_packge(Request $request){
        $pakge = Package::find($request->packge_id);
        return response()->json(['price' => $pakge->price]);
    }
    public function ref_code(){
        $users = User::get();
        foreach($users as $user){
            $user->random_id = $user->name.'_'.now()->timestamp;
            $user->save();
        }
        
    }

    public function get_users(){
        $now = today();
        $threeDaysFromNow = $now->addDays(3);
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
            Mail::to($user->email)->send(new AlertSubscribe($user->name,$user->email, $threeDaysFromNow));
        }
        return $users;
    }
    public function login_admin(){
        return view('dashboard.auth.login');
    }
    public function profile(){
        $user = auth('admin')->user();
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
        return redirect()->route('login');
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
            return response()->json(['error' =>'البريد الاكتروني غير مسجل لدينا .   سيتم تحويلك لصفحة التسجيل ','status'=>'er'], 422);
        }
        if($user->is_paid ==0){
            return response()->json(['error' =>'يرجى الدفع والاشتراك حتى تتمكن من تسجيل حضورك     . سيتم تحويلك لصفحة الباقات   ','status'=>'erere'], 422);
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
    public function member_setting(){
        return view('dashboard.member_setting');
    }
    public function setting(){
        return view('dashboard.setting_info');
    }

    
}
