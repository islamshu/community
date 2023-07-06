<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunutyResoures extends JsonResource
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
            'title'=>$this->title,
            'image'=>asset('uploads/'.$this->image),
            'meeting_date'=>Carbon::parse($this->meeting_date)->format('Y-m-d H:i:s'),
            'meeting_url'=>$this->meeting_url,
            'meeting_end'=>$this->meeting_end,
        ];
    }
}
