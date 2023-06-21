<?php

namespace App\Http\Resources;

use App\Models\Domians;
use App\Models\UserVideo;
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
            'is_able_to_affilite'=>$this->is_able_affilete,
            'domains'=>$this->get_domains($this),
            'create_at'=>$this->created_at->format('Y-m-d H:i:s'),
            'star_color'=>$this->get_color($this),
            'last_meeting_show'=>@UserVideo::where('email',$this->email)->orderby('id','desc')->first()->date,
            'social' => NewSoicalResoures::collection($this->soical_new),
            'random_id'=>$this->random_id,
            'answer_questione' =>  AnsweResourse::collection($this->answer),
            'affilite_url'=>$this->affilite_url($this),
            'is_verify'=>$this->email_verified_at == null ? 0 : 1,
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
    function get_domains($data){
        // dd($data->domains);
        $col = Domians::whereIn('id',json_decode($data->domains))->get();
        return DomiansResourse::collection($col);
    }
    function affilite_url($data){
        if($data->ref_code == null){
            return null;
        }else{
            return route('my_affilite',$data->ref_code);
            return 'https://community.arabicreators.com/?ref='.$data->ref_code;
        }
    }
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
