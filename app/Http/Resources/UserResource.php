<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'star_color'=>$this->get_color($this),
            'social' => new SocialResource($this->soical),
            'answer_questione' =>  AnsweResourse::collection($this->answer),
            'video_profile'=>asset('uploads/'.get_general_value('video_profile')),

        ];
    }
    // function get_image($data){
    //     if($data->image != null){
    //       return  asset('uploads/'.$data->image);
    //     }else{
    //      return route('user_profile',$data->name);
    //     }
    // }
    function get_color($data){
        if($data->is_paid == 1){
            return 'yellow';
        }elseif($data->is_paid == 0){
            if($data->is_finish == 1){
                return 'red';
            }else{
                return 'green';
            }
        }
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
