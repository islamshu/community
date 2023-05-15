<?php

namespace App\Http\Controllers;

use App\Models\BankInfo;
use Illuminate\Http\Request;

class BankInfoController extends Controller
{
    public function all(){
        $banks = BankInfo::orderby('id','desc')->get();
        $progress = BankInfo::where('status',2)->orderby('id','desc')->get();
        $done = BankInfo::where('status',1)->orderby('id','desc')->get();
        $regiect = BankInfo::where('status',0)->orderby('id','desc')->get();

        return view('dashboard.banks.index')->with('banks',$banks)->with('progress',$progress)->with('done',$done)->with('regiect',$regiect);
    }
}
