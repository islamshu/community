<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
