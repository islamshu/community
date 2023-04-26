<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ToolsLinksResoures extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
                'url' => $this->url,
                'type' => $this->type,
                'icon'=>$this->get_icon($this)
            ];
    }
    function get_icon($data){
        if($data->type == 'apple'){
            return asset('uploads/icons/apple.png');
        }elseif($data->type == 'google'){
            return asset('uploads/icons/google.png');
        }elseif($data->type == 'AppGallery'){
            return asset('uploads/icons/AppGallery.png');
        }elseif($data->type =='url'){
            return asset('uploads/icons/url.png');
        }
    }
}
