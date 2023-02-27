<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ToolsResource extends JsonResource
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
            'description'=>$this->description,
            'image'=>asset('uploads/'.$this->image),
            'price'=>$this->price,
            'type'=>$this->type == 'free' ? 'مجاني' :'مدفوع',
            'urls'=>ToolsLinksResoures::collection($this->links),
        ];
    }
}
