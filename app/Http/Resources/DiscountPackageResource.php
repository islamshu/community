<?php

namespace App\Http\Resources;

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
            'price'=>$this->get_price($this),
            'discount_amount'=>$this->discount,
        ];
      
    }
    function get_price($data){
        $main_price = $data->package->price;
        $discount_price = $main_price * ($data->discount/ 100);
        $discount_price = $main_price -$discount_price; 
        return number_format( $discount_price,2);
    }
}
