<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'user_id'=>$this->id,
            'user_name'=>$this->name,
            'image'=>asset('uploads/'.$this->image),
            'message_url'=>route('message_two',[$this->id,auth('api')->id()])
        ];
    }
}
