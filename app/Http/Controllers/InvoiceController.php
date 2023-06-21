<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invoice as InvoiceMail;

class InvoiceController extends Controller
{
    public function index(){
        return view('dashboard.invoice.index')->with('users',User::get())->with('invoices',Invoice::orderby('id','desc')->get());
    }
    public function store(Request $request){
        $invoice = new Invoice();
        $invoice->code  = date('Ymd-His').rand(10,99);
        $invoice->user_id = $request->user_id;
        $invoice->peroid = $request->peroid;
        $invoice->start_at =  Carbon::parse($request->start_at)->format('Y-m-d');
        $invoice->end_at =  Carbon::parse($request->end_at)->addMonths($request->peroid)->format('Y-m-d');
        $invoice->main_price = $request->main_price;
        $invoice->discount_code = $request->discount_code;
        $invoice->price_after_discount = $request->price_after_discount;
        $invoice->discount_amount = $invoice->main_price - $request->price_after_discount;
        $invoice->save();
        $user = User::find($request->user_id);
        Mail::to($user->email)->send(new InvoiceMail($user->name,$user->email,$invoice->start_at,$invoice->end_at,$invoice->code,$invoice->peroid));
        // dd('test');
        return redirect()->route('invoices.index')->with(['success'=>'تم اضافة الفاتورة بنجاح']);
    }
}
