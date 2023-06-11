<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankInfoResource extends JsonResource
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
            'type'=>json_decode($this->type),
            'paypal_email'=>$this->paypal_email,
            'fullname'=>$this->fullname,
            'fullnameArabic'=>$this->fullnameArabic,
            'counrty'=>$this->counrty,
            'city'=>$this->city,
            'phone'=>$this->phone,

            'persionID'=>$this->persionID,
            'Idimage'=>$this->Idimage != null ? asset('uploads/'.$this->Idimage) : null,
            'bank_name'=>$this->bank_name,
            'ibanNumber'=>$this->ibanNumber,
            'owner_name'=>$this->owner_name,
            'status'=>$this->status,
            'error_message'=>$this->error_message,
            'user_id'=>new UserResource($this->user)
        ];
    }
}
