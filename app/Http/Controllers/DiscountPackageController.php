<?php

namespace App\Http\Controllers;

use App\Models\DiscountPackage;
use App\Rules\UniqueDateRange;
use App\Rules\UpdateUniqeDate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class DiscountPackageController extends Controller
{
    public function index(){
        return view('dashboard.packgeDiscount.index')->with('packges',DiscountPackage::orderby('id','desc')->get());
    }
    public function edit($id){
        return view('dashboard.packgeDiscount.edit')->with('packge',DiscountPackage::find($id));
    }
    public function update(Request $request,$id){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', new UpdateUniqeDate(
                $request->input('package_id'),
                $request->input('start_at'),
                $request->input('end_at'),
                $id
            )],
            'package_id' => ['required', 'exists:packages,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    // Find the discount by ID and update its attributes
    $discount = DiscountPackage::findOrFail($id);
    $discount->update($request->all());
    
        return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
    }
    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', new UniqueDateRange(
                $request->input('package_id'),
                $request->input('start_at'),
                $request->input('end_at'),
                null
            )],
            'package_id' => ['required', 'exists:packages,id'],
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Validation passes, create the new Discount object
        $discount = DiscountPackage::create($request->all());
    
    
        return redirect()->back()->with(['success'=>'تم الانشاء بنجاح']);
    }
    public function destroy($id){
        $discount = DiscountPackage::find($id);
        $discount->delete();
        return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
    }
}
