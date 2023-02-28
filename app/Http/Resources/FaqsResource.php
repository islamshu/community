<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         
        $offers = Offer::with('vendor')->whereHas('vendor', function ($q) use ($request , $city) {
            $q->where('status','active');
        })->get();
       
        return [
            'qustion'=>$this->question,
            'answer'=>$this->answer,
        ];
    }
}
