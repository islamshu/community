<?php

namespace App\Http\Resources;

use App\Models\CommunityUser;
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
            'is_notofiy_to_me'=>$this->is_notofiy($this)
        ];
    }
    function is_notofiy($data){
        if(!auth('api')->check()){
            return 0;    
        }elseif(auth('api')->check()){
          $com=  CommunityUser::where('user_id',auth('api')->id())->where('communitiye_id',$id)->first();
            if($com){
                return 1;
            }else{
                return 0;
            }
        }
    }
}
