<?php

namespace App\Http\Resources;

use App\Models\Package;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResoures extends JsonResource
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
            // 'user_info'=>new UserResource($this->user),
            'code'=>$this->code,
            'start_at'=>$this->start_at,
            'end_at'=>$this->end_at,
            'type'=>$this->get_type($this),
            'main_price'=>number_format($this->main_price,1),
            'price_after_discount'=>number_format($this->price_after_all_discount,1),
            'discount_price'=>number_format($this->main_price - $this->price_after_all_discount,1),
            'discount_code'=>($this->discount_code),
            'show_pdf'=>route('invoideviewPdf',$this->code)
        ];
    }
    function get_type($data){
        if($data->peroid == 1 ){
            return 'اشتراك شهري';
        }else{
            return 'اشتراك سنوي';
        } 
        // dd($pca);
    }
}
