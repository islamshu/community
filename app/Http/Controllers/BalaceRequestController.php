<?php

namespace App\Http\Controllers;

use App\Models\BlalnceRequest;
use Illuminate\Http\Request;

class BalaceRequestController extends Controller
{
    public function index(){
        $balace = BlalnceRequest::orderby('id','desc')->get();
        return view('dashboard.balance.index')->with('balaces',$balace);
    }
}
