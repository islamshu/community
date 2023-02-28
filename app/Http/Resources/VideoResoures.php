<?php

namespace App\Http\Resources;

use App\Models\User;
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
            'date'=>$this->date,
            'number_of_guest'=>$this->num_guset,
            'users'=>$this->get_users($this)
        ];
    }
    function get_users($data){
        $users = $data->users;
        $array=[];
        foreach($users as $user){
            array_push($array,$user->user_id);
        }
        return UserVideoResourese::collection(User::whereIn('id',$array)->get());
    }
}
