<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.currencies.index')->with('currencies',Currency::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.currencies.create')->with('currencies',Currency::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $curreny = new Currency();
        $curreny->name = $request->title;
        $curreny->status = 1;
        $curreny->symbol = $request->symbol;
        $curreny->value_in_dollars = $request->amount_as_dollar;
        $curreny->save();
        return redirect()->route('currencies.index')->with(['success'=>'تم الاضافة بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updated_status (Request $request){
        $curreny = Currency::find($request->currencie_id);
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
        return view('dashboard.currencies.edit')->with('currencie',Currency::find($id));

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
        $curreny =  Currency::find($id);
        $curreny->name = $request->title;
        $curreny->status = 1;
        $curreny->symbol = $request->symbol;
        $curreny->value_in_dollars = $request->amount_as_dollar;
        $curreny->save();
        return redirect()->route('currencies.index')->with(['success'=>'تم التعديل بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curreny =  Currency::find($id);
        $curreny->delete();
        return redirect()->route('currencies.index')->with(['success'=>'تم الحذف بنجاح']);
    }
}
