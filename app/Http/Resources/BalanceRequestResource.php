<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BalanceRequestResource extends JsonResource
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
            'payment_method'=>$this->paid_method,
            'status'=>get_status($this->status),
            'send_at'=>$this->created_at,
            'payment_detiles'=>json_decode($this->payment_detiles)
        ];
    }
}
