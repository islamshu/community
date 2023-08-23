<?php

namespace App\Http\Resources;

use App\Models\Currency;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountPackageResource extends JsonResource
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
            // 'id'=>$this->id,
            'start_at'=>$this->start_at,
            'end_at'=>$this->end_at,
            'price'=>$this->get_price($request,$this),
            'discount_amount'=>$this->discount,
        ];
      
    }
    function get_price($request,$data){
        if($request->currency == null){
            $main_price = $data->package->price;
            $discount_price = $main_price * ($data->discount/ 100);
            $discount_price = $main_price -$discount_price; 
            return number_format( $discount_price,2);
        }else{
            $main_price = $data->package->price;
            $discount_price = $main_price * ($data->discount/ 100);
            $currency = Currency::find($request->currency);
            $discount_price = ($main_price -$discount_price)* $currency->value_in_dollars; 
            return number_format( $discount_price,2);
        }

        
    }
}
