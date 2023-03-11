<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToolsResource;
use App\Models\Tool;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BookResoures;
use App\Http\Resources\FaqsResource;
use App\Http\Resources\PackageResoures;
use App\Http\Resources\PartnerResourse;
use App\Http\Resources\QuastionResourse;
use App\Http\Resources\UserResource;
use App\Http\Resources\VideoResoures;
use App\Models\Book;
use App\Models\Faqs;
use App\Models\MailSubscription;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Quastion;
use App\Models\User;
use App\Models\Video;
use Validator;
use Illuminate\Support\Facades\Http;

class HomeController extends BaseController
{
    public function tools(){
        $tools = Tool::orderby('id','desc')->paginate(6);
        $res = ToolsResource::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الاسئلة');
    }
    public function services(){
        $response = Http::get('http://dashboard.arabicreators.com/api/get_all_service');
        return json_decode( $response->body()) ;
    }
    public function single_service($slug){
        $q = array();
        $response = Http::get('http://dashboard.arabicreators.com/api/single_service/'.$slug);
        $data = json_decode( $response->body());
        array_push($q,$data);
        $q['link_to_pay']='dd';
        return $q;
        return json_decode( $response->body()) ;
    }
    
    public function questions(){
        $tools = Quastion::paginate(2);
        $res = QuastionResourse::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الادوات');
    }

    
    public function partners(){
        $tools = Partner::orderby('id','desc')->get();
        $res = PartnerResourse::collection($tools);
        return $this->sendResponse($res,'جميع الشركاء');
    }
    public function single_partner($id){
        $tools = Partner::find($id);
        $res = new PartnerResourse($tools);
        return $this->sendResponse($res,'تم ارجاع الشريك بنجاح');
    }
    public function faqs(){
        $faqs = Faqs::orderby('sort','asc')->get();
        $res = FaqsResource::collection($faqs);
        return $this->sendResponse($res, ' faqs page');

    }
    public function mail_sub(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $m = MailSubscription::where('email',$request->email)->first();
        if($m){
            return $this->sendError('البريد الاكتروني مشترك من قبل');
        }
        $mail = new MailSubscription();
        $mail->email = $request->email;
        $mail->save();
        $res =[
            'mail'=>$mail->email
        ];
        return $this->sendResponse($res,'تم الاشتراك  بنجاح');
    }

    
    public function sinlge_tool($id){
        $tool = Tool::find($id);
        $res = new ToolsResource($tool);
        return $this->sendResponse($res,'تم ارجاع الاداة');
    }
    public function users(){
        $users = User::where('type','user')->where('is_paid',1)->orderby('id','desc')->get();
        $res = UserResource::collection($users);
        return $this->sendResponse($res,'جميع الاعضاء');
    }
    public function packages(){
        $tools = Package::orderby('id','desc')->paginate(6);
        $res = PackageResoures::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الباقات');
    }
    public function single_package($id){
        $tools = Package::find($id);
        $res = new PackageResoures($tools);
        return $this->sendResponse($res,'تم ارجاع الباقة بنجاح');
    }
    public function books(){
        $tools = Book::orderby('id','desc')->paginate(6);
        $res = BookResoures::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الكتب');
    }
    public function single_book($id){
        $tools = Book::find($id);
        $res = new BookResoures($tools);
        return $this->sendResponse($res,'تم ارجاع الكتاب بنجاح');
    }
    public function videos(){
        $tools = Video::orderby('id','desc')->paginate(6);
        $res = VideoResoures::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الجلسات');
    }
    public function home_videos(){
        $tools = Video::orderby('id','desc')->where('in_home',1)->paginate(6);
        $res = VideoResoures::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الجلسات');
    }

    
    public function single_video($id){
        $tools = Video::find($id);
        $res = new VideoResoures($tools);
        return $this->sendResponse($res,'تم ارجاع الجلسة بنجاح');
    }
}
