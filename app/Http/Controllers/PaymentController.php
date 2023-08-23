<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_payment($id){
        $payments = Payment::whereJsonContains('currencie_ids', $id)->get();
        dd($payments);
    }
    public function index()
    {
        return view('dashboard.payments.index')->with('payments',Payment::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.payments.create')->with('currencies',Currency::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $curreny = new Payment();
        $curreny->name = $request->title;
        $curreny->image = $request->image->store('payment');
        $curreny->currencie_ids = json_encode($request->currencie_ids);
        $curreny->value = $request->value;

        $curreny->save();
        return redirect()->route('payments.index')->with(['success'=>'تم الاضافة بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updated_status (Request $request){
        $curreny = Payment::find($request->payment_id);
        $curreny->status = $request->status;
        $curreny->save();
    } 

    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboard.payments.edit')->with('payment',Payment::find($id))->with('currencies',Currency::get());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $curreny =  Payment::find($id);
        $curreny->name = $request->title;
        if($request->image != null){
            $curreny->image = $request->image->store('payment');
        }
        $curreny->value = $request->value;
        $curreny->currencie_ids = json_encode($request->currencie_ids);
        $curreny->save();
        return redirect()->route('payments.index')->with(['success'=>'تم التعديل بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curreny =  Payment::find($id);
        $curreny->delete();
        return redirect()->route('payments.index')->with(['success'=>'تم الحذف بنجاح']);

    }
}
