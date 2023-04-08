<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
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
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'have_website'=>$this->have_website,
            'site_url'=>$this->site_url,
            'image'=>$this->get_image($this),
            'video'=>asset('uploads/'.$this->video),
            'packege'=>new PackageResoures($this->packege),
            'is_paid'=>$this->is_paid,
            'domains'=>$this->domains,
            'social' => new SocialResource($this->soical),
            'video_profile'=>asset('uploads/'.get_general_value('video_profile')),
            'answer_questione' =>  AnsweResourse::collection($this->answer),
            'token' => $this->createToken('Personal Access Token')->accessToken,
        ];
    }
    function get_image($data){
        // if($data->image != null){
        //     dd()
        //   return  asset('uploads/'.$data->image);
        // }else{
        //  return route('user_profile',$data->name);
        // }
        return  asset('uploads/'.$data->image);

    }
}
