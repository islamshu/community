<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invoice as InvoiceMail;
use App\Models\Package;

class InvoiceController extends Controller
{
    public function index(){
        return view('dashboard.invoice.index')->with('users',User::get())->with('invoices',Invoice::orderby('id','desc')->get());
    }
    public function store(Request $request){
        // dd($request);
        $pac = Package::find($request->peroid);
        $invoice = new Invoice();
        $invoice->code  = date('Ymd-His').rand(10,99);
        $invoice->user_id = $request->user_id;
        $invoice->peroid = $pac->period;
        $invoice->start_at =  Carbon::parse($request->start_at)->format('Y-m-d');
        $invoice->end_at =  Carbon::parse($request->end_at)->addMonths($request->peroid)->format('Y-m-d');
        $invoice->main_price = $request->price;
        $invoice->discount_code = $request->discount_code;
        $invoice->price_after_discount = $request->price_after_discount;
        $invoice->discount_amount = $invoice->main_price - $request->price_after_discount;
        $invoice->save();
        $user = User::find($request->user_id);
        Mail::to($user->email)->send(new InvoiceMail($invoice->id));
        // dd('test');
        return redirect()->route('invoices.index')->with(['success'=>'تم اضافة الفاتورة بنجاح']);
    }
}
