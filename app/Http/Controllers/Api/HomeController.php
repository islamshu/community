<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToolsResource;
use App\Models\Tool;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BookResoures;
use App\Http\Resources\DomiansResourse;
use App\Http\Resources\FaqsResource;
use App\Http\Resources\MemberResoures;
use App\Http\Resources\PackageResoures;
use App\Http\Resources\PartnerResourse;
use App\Http\Resources\QuastionResourse;
use App\Http\Resources\UserResource;
use App\Http\Resources\VideoResoures;
use App\Models\Book;
use App\Models\Domians;
use App\Models\Faqs;
use App\Models\GeneralInfo;
use App\Models\MailSubscription;
use App\Models\MarkterSoical;
use App\Models\Member;
use App\Models\Order;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Quastion;
use App\Models\User;
use App\Models\UserVideo;
use App\Models\Video;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Http;

class HomeController extends BaseController
{
    public function add_socail(){
        $users = User::where('type','user')->get();
        foreach($users as $user){
            $social = $user->soical;
            $social = new MarkterSoical();
            $social->user_id = $user->id;
            $social->save();
        }
    }
    public function domains(){
        $domans = Domians::orderby('id','desc')->get();
        $res = DomiansResourse::collection($domans);
        return $this->sendResponse($res,'جميع المجالات');
    }
    public function setting(){
        $res=[
            'icon'=>asset('uploads/'.get_general_value('icon_front')),
            'image'=>asset('uploads/'.get_general_value('image_front')),
            'email'=>get_general_value('email'),
            'whataspp'=>'https://api.whatsapp.com/send/?phone='.get_general_value('whataspp').'&text&type=phone_number&app_absent=0',
        ];
        return $this->sendResponse($res,'بيانات الموقع');

    }
    public function add_email_to_data(Request $request){
        $user = auth('api')->user();
        $check = UserVideo::where('email', $user->email)->where('date',$request->date)->first();
        if($check){
            return $this->sendError('لقد تم التسجيل من قبل');
        }
        $vid = new UserVideo();
        $vid->email = $user->email;
        $vid->date = $request->date;
        $vid->save();
        return $this->sendResponse('success','تم تسجيل الدخول للجلسة');

    }
    
    public function avaliable_tabs(){
        $res = [
            'videos'=>(int)get_general_value('videos'),
            'tools'=>(int)get_general_value('tools'),
            'services'=>(int)get_general_value('services'),
            'videos_leraning'=>(int)get_general_value('videos_leraning'),
            'members'=>(int)get_general_value('members'),
            'offers'=>(int)get_general_value('offers'),
            ];
            return $this->sendResponse($res,'جميع التابات المتاحة والمرفوضة');

    }
    public function tools(){
        $tools = Tool::orderby('id','desc')->paginate(6);
        $res = ToolsResource::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الاسئلة');
    }
  
    public function services(Request $request) {
        $url = "http://dashboard.arabicreators.com/api/get_all_service";
        if ($request->page !== null) {
            $url .= "?page=$request->page";
        }
        // dd($url);
        $response = Http::get($url);        
        return json_decode($response->body());
    }
    
    
    
    
    public function testpc(){
        return route('user_profile','islam');
        $order = new Order();
        $url = 'https://api.test.paymennt.com/mer/v2.0/checkout/web';
        $data = [
            'description'=> 'dozen of cookies',
            'currency'=> 'AED',
            'amount'=> 1499.99,
            'customer'=> [
                'firstName'=> 'islam',
                'lastName'=> 'shublaq',
                'email'=> 'islamshublaq@hotmail.com',
                'phone'=> '00970592722789'
            ],
            'items'=> [
            [
                "name"=> "Dark grey sunglasses",
                "sku"=> "1116521",
                "unitprice"=> 50,
                "quantity"=> 2,
                "linetotal"=> 100
            ]
            ],
            'billingAddress'=>[
                'name'=>'islam',
                'address1'=>'palestine',
                'city'=>'gaza',
                'country'=>'palestine',
            ],
            'returnUrl'=>'https://ably.com/blog/building-a-realtime-chat-app-with-react-laravel-and-websockets',
            'orderId'=> now(),
            'requestId'=> now(),

        ];
        $headers = [
            'Content-Type' => 'application/json',
            'X-PointCheckout-Api-Key'=>'186dfbff90cd115d',
            'X-PointCheckout-Api-Secret'=>'mer_5cf8cbe5d3bdb5f8f8486d1412e20537ed226c92754af61fb39d33d37ac6fe2f',
        ];
        $response = Http::withHeaders($headers)->post($url, $data);
        $data =  json_decode( $response->body()) ;
        return $data->result->redirectUrl;
    }
    public function learning(Request $request){

        $url = "http://dashboard.arabicreators.com/api/get_all_videos";
        if ($request->page !== null) {
            $url .= "?page=$request->page";
        }
        // dd($url);
        $response = Http::get($url);        
        return json_decode($response->body());
        
    }
    public function single_learning($slug) {
        $response = Http::get('http://dashboard.arabicreators.com/api/single_video/'.$slug);
        $res = json_decode($response->body())->data;
    
        return $this->sendResponse($res, 'تم ارجاع الفيديو '); 
    }
    public function single_service($slug) {
        $response = Http::get('http://dashboard.arabicreators.com/api/single_service/'.$slug);
        $data = json_decode($response->body())->data;
        $data->link_to_pay = "https://sub.arabicreators.com/OurServices/".$slug;
        $res = ['data' => $data];
        return $this->sendResponse($res, 'جميع الادوات'); 
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
    public function mail_sub(Request $request){
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
        $users = User::where('type','user')->where('is_paid',1)->orderby('id','desc')->paginate(6);
        $res = UserResource::collection($users)->response()->getData(true);
        return $this->sendResponse($res,'جميع الاعضاء');
    }
    public function users_home(){
        $users = User::where('type','user')->where('is_paid',1)->orderby('id','desc')->get();
        $res = UserResource::collection($users);
        return $this->sendResponse($res,'جميع الاعضاء');
    }
    public function meeting_setting(){
        $res =[
            'meeting_date'=>get_general_value('meeting_date'),
            'meeting_url'=>get_general_value('meeting_url'),
        ];
        return $this->sendResponse($res,'بيانات الجلسة');

    }
    public function get_user($id){
        $users = User::find($id);
        $res = new UserResource($users);
        return $this->sendResponse($res,'تم ارجاع البيانات بنجاح ');
    }

    
    public function packages(){
        $tools = Package::orderby('id','desc')->paginate(12);
        $res = PackageResoures::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الباقات');
    }
    public function members(){
        $members = Member::get();
        $res = MemberResoures::collection($members);;
        return $this->sendResponse($res,'جميع مستخدمي النظام');
    }
    public function single_package($id){
        $tools = Package::find($id);
        $res = new PackageResoures($tools);
        return $this->sendResponse($res,'تم ارجاع الباقة بنجاح');
    }
    public function books(){
        $tools = Book::orderby('id','desc')->paginate(12);
        $res = BookResoures::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الكتب');
    }
    public function single_book($id){
        $tools = Book::find($id);
        $res = new BookResoures($tools);
        return $this->sendResponse($res,'تم ارجاع الكتاب بنجاح');
    }
    public function videos(){
        $tools = Video::orderby('id','desc')->paginate(12);
        $res = VideoResoures::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الجلسات');
    }
    public function home_videos(){
        $tools = Video::orderby('id','desc')->where('in_home',1)->paginate(12);
        $res = VideoResoures::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الجلسات');
    }

    
    public function single_video($id){
        $tools = Video::find($id);
        $res = new VideoResoures($tools);
        return $this->sendResponse($res,'تم ارجاع الجلسة بنجاح');
    }
}
