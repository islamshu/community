<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvalabeTabsResourse extends JsonResource
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
            'videos'=>1,
            'tools'=>1,
            'services'=>1,
            'videos_leraning'=>1,
            'members'=>1,
            'offers'=>1,
            ];
    }
}
