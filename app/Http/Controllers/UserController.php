<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
class UserController extends Controller
{
    public function index(){
        $users = User::where('type','user')->orderby('id','desc')->get();
        return view('dashboard.users.index')->with('users',$users)->with('title','جميع المستخدمين');
    }
    public function paid_user(){
        $users = User::where('type','user')->where('is_paid',1)->orderby('id','desc')->get();
        return view('dashboard.users.index')->with('users',$users)->with('title','جميع المستخدمين الدافعين');
    }
    public function un_paid_user(){
        $users = User::where('type','user')->where('is_paid',0)->orderby('id','desc')->get();
        return view('dashboard.users.index')->with('users',$users)->with('title','جميع المستخدمين الغير دافعين');
    }
    public function create(){
        return view('dashboard.users.create');
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'phone' => 'required|unique:users,phone',
            'have_website' => 'required',
            'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->phone = $request->phone;
        $user->have_website = $request->have_website;
        $user->site_url = $request->site_url;
        $user->type = 'user';
        $user->image = $request->image->store('users');
        $user->video = 'user_video/defult.mp4';
        $user->packege_id = $request->packege_id;
        $user->is_paid = 1;
        $user->save();
        return redirect()->route('users.index');
    }
}
