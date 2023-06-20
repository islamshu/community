<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.discount.index')->with('discount', DiscountCode::orderby('id', 'desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.discount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = new DiscountCode();
        $code->title = $request->title;
        $code->start_at = $request->start_at;
        $code->end_at = $request->end_at;
        $code->code = $this->generate_code();
        $code->discount_type = $request->discount_type;
        $code->discount_value = $request->discount_value;
        $code->save();
        return redirect()->route('discountcode.index')->with(['success' => 'تم اضافة كود الخصم بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboard.discount.edit')->with('discount', DiscountCode::find($id));
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
        $code = DiscountCode::find($id);
        $code->title = $request->title;
        $code->start_at = $request->start_at;
        $code->end_at = $request->end_at;
        // $code->code = rand(11111,99999);
        $code->discount_type = $request->discount_type;
        $code->discount_value = $request->discount_value;
        $code->save();
        return redirect()->route('discountcode.index')->with(['success' => 'تم تعديل كود الخصم بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $code = DiscountCode::find($id);
        $code->delete();
        return redirect()->route('discountcode.index')->with(['success' => 'تم حذف كود الخصم بنجاح']);
    }
    function generate_code()
    {
        $code = rand(11111, 99999);
        if (DiscountCode::where("code", $code)->exists()) {
            self::generate_code();
        } else {
            return $code;
        }
    }
}
