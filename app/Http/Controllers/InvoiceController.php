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
        $invoice->start_at =  Carbon::parse($request->start_at);
        $invoice->end_at =  Carbon::parse($request->end_at)->addMonths($request->peroid);
        $invoice->save();
        dd($invoice->user->email);
        Mail::to($invoice->user->email)->send(new InvoiceMail($invoice->user->name,$invoice->user->email,$invoice->start_at,$invoice->end_at,$invoice->code,$invoice->peroid));

        return redirect()->route('invoices.index')->with(['success'=>'تم اضافة الفاتورة بنجاح']);
    }
}
