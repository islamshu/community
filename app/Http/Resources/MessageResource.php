<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'sender'=>new UserVideoResourese($this->sender),
            'receiver'=>new UserVideoResourese($this->receiver),
            'message'=>$this->message,
            'time'=>$this->created_at->diffForHumans()
        ];
    }
}