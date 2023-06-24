<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewSoicalResoures extends JsonResource
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
            'username'=>$this->name,
            'path'=>$this->url,
            'icon'=>asset('socail/'.$this->name.'.svg'),
            'username'=>$this->user_name,
            'isactive'=>$this->is_active
        ];
    }
}
