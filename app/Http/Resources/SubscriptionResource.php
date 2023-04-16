<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'amount'=>$this->amount,
            'start_at'=>$this->start_at,
            'end_at'=>$this->end_at,
            'payment_method'=>$this->payment_method,
            'package'=>new PackageResoures($this->package),
            'package_title'=>$this->package->title,
            'package_price'=>$this->package->price,
            'package_description'=>$this->package->description,
            'image'=>asset('uploads/'.$this->package->image)



        ];
    }
    
}
