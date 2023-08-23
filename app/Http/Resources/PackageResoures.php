<?php

namespace App\Http\Resources;

use App\Models\Currency;
use App\Models\DiscountPackage;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResoures extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'description'=>$this->description,
            'price'=>get_price($request,$this),
            'image'=>asset('uploads/'.$this->image),
            'discount'=>$this->get_descount($this)
        ];
    }
    function get_descount($data){
        $currentDate = Carbon::today()->toDateString();

       $dis= DiscountPackage::where('package_id',$data->id)->whereDate('start_at', '<=', $currentDate)
    ->whereDate('end_at', '>=', $currentDate)
    ->first();
    return new DiscountPackageResource($dis);
    }
    function get_price($request,$data){
        if($request->currency == null){
            return $this->price;
        }else{
            $currency = Currency::find($request->currency);
            return $this->price * $currency->value_in_dollars;
        }
    }
}
