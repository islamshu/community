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
            'user_id'=>$this->sender->id,
            // 'sender'=>new UserVideoResourese($this->sender),
            // 'receiver'=>new UserVideoResourese($this->receiver),
            'i_sender'=>$this->sender_id == auth('api')->id() ? 1 : 0,
            'message'=>$this->message,
            'time'=>$this->created_at->diffForHumans()
        ];
    }
}
