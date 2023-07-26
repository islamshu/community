<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountCodeResourse extends JsonResource
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
            'code'=>$this->code,
            'start_at'=>$this->start_at,
            'end_at'=>$this->end_at,
            'discount_type'=>$this->discount_type,
            'discount_value'=>$this->discount_value

        ];
    }
}
