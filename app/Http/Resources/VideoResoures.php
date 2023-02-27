<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResoures extends JsonResource
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
            'image'=>asset('uploads/'.$this->image),
            'title'=>$this->title,
            'description'=>$this->description,
            'type'=>$this->type =='url' ? 'رابط' :'ملف',
            'url'=>$this->url,
            'file'=>$this->file,
        ];
    }
}
