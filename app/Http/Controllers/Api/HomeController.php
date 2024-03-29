<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToolsResource;
use App\Models\Tool;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BookResoures;
use App\Http\Resources\CommunutyResoures;
use App\Http\Resources\DomiansResourse;
use App\Http\Resources\FaqsResource;
use App\Http\Resources\MemberResoures;
use App\Http\Resources\PackageResoures;
use App\Http\Resources\PartnerResourse;
use App\Http\Resources\QuastionResourse;
use App\Http\Resources\UserResource;
use App\Http\Resources\VideoResoures;
use App\Models\Book;
use App\Models\Community;
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
use App\GoogleMeetService;
use App\Http\Resources\CurrencyResoures;
use App\Http\Resources\PaymentResoures;
use App\Models\Invoice;
use App\Mail\ReminderEmail;
use App\Models\CommunityUser;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\Subscription;

class HomeController extends BaseController
{
    public function socail(){
        $res['facebook']= get_general_value('facebook');
        $res['instagram']= get_general_value('instagram');
        $res['twitter']= get_general_value('twitter');
        $res['whataspp_number']= get_general_value('whataspp');
        $res['linkedin']= get_general_value('linkedin');
        $res['behance']= get_general_value('behance');
        $res['email']= get_general_value('email');
        return $this->sendResponse($res,'all spcail');
    }
    public function testapi(){
        $subs = Subscription::get();
        foreach($subs as $sub){
            if($sub->price_after_all_discount == null){
                $sub->price_with_currency =  $sub->amount;
                $sub->price_after_all_discount =  $sub->amount;

            }else{
                $sub->price_with_currency =  $sub->price_after_all_discount;
            }
          $sub->save();
        }
        $invs = Invoice::get();
        foreach($invs as $in){
            $in->price_with_currency = $in->price_after_all_discount;
            $in->save();
        }
    }
    public function currencies(){
        $currenes = Currency::where('status',1)->get();
        $res = CurrencyResoures::collection($currenes);
        return $this->sendResponse($res,'all Currency');
    }
    public function payments(){
        $currenes = Payment::where('status',1)->get();
        $res = PaymentResoures::collection($currenes);
        return $this->sendResponse($res,'all payments');
    }
    public function  payments_by_currencies($id){
        $payments = Payment::whereJsonContains('currencie_ids', $id)->get();
        $res = PaymentResoures::collection($payments);
        return $this->sendResponse($res,'all payments');
    }
    public function blogs(Request $request){

            $url = "http://dashboard.arabicreators.com/api/get_all_blogs";
            if ($request->page !== null) {
                $url .= "?page=$request->page";
            }
            // dd($url);
            $response = Http::get($url);        
            return json_decode($response->body());
    }
    public function notify_me($id){
        $comuserexist = CommunityUser::where('user_id',auth('api')->id())->where('communitiye_id',$id)->first();
        if($comuserexist){
            $comuserexist->delete();
            return $this->sendResponse('success','تم اللغاء التنبيهات');
        }else{
            $co =new  CommunityUser();
            $co->user_id = auth('api')->id();
            $co->communitiye_id = $id;
            $co->save();
            return $this->sendResponse('success','تم الاشتراك بالتنبيهات');
        }
    }
    public function edit_dsicount(){
        $invoice = Invoice::where('price_after_all_discount',null)->get();
        foreach($invoice as $in){
            $in->price_after_all_discount = $in->price_after_discount;
            $in->save();
        }
    }
    public function visa_image(){
        $images = [
            'visa'=>asset('visa/visa.png'),
            'mada'=>asset('visa/mada.png'),
            'master'=>asset('visa/mastercard.png'),
            'paypal'=>asset('visa/paypal.jpg'),
            'stripe'=>asset('visa/stripe.png'),
            'stc'=>asset('visa/stc.jpg'),   
        ];
        return $this->sendResponse($images,'صور الدفع');

    }
    public function get_all_videos_from_community($id){
        $videos = Video::where('community_id',$id)->get();
        $res = VideoResoures::collection($videos);
        return $this->sendResponse($res,'جميع الجلسات الخاصة بالمجتمع');

    }
    public function bank_info_images(){
        $image[0]['title']='Paypal';
        $image[0]['value']='paypal';
        $image[0]['image']=asset('uploads/bankinfo_image/paypal.jpg');
        $image[1]['title']='Western Union';
        $image[1]['value']='westron';
        $image[1]['image']=asset('uploads/bankinfo_image/westren.jpg');
        $image[2]['title']='Bank';
        $image[2]['value']='bank';
        $image[2]['image']=asset('uploads/bankinfo_image/bank.jpg');

        return $this->sendResponse($image,'صور الدفع');

    }
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
            'statistic'=>(int)get_general_value('statistic')
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
        $users = User::get();
        foreach($users as $us){
            $us->domains = ["1"];
            $us->save();
        }
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
    public function single_blog($slug) {
        $response = Http::get('http://dashboard.arabicreators.com/api/single_blog_new/'.$slug);
        $res = json_decode($response->body())->data;
    
        return $this->sendResponse($res, 'تم ارجاع المقال '); 
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
        $tools = Package::where('for_admin',0)->paginate(12);
        $res = PackageResoures::collection($tools)->response()->getData(true);
        return $this->sendResponse($res,'جميع الباقات');
    }
    public function community(){
        $communites = Community::orderby('id','desc')->get();
        $res = CommunutyResoures::collection($communites);
        return $this->sendResponse($res,'جميع المجتمعات');      
    }
    public function single_community($id){
        $communiy = Community::find($id);
        $res = new CommunutyResoures($communiy);

        return $this->sendResponse($res,'تم ارجاع المجتمع بنجاح');      
    }
    public function members(){
        $members = Member::get();
        $res = MemberResoures::collection($members);;
        return $this->sendResponse($res,'جميع مستخدمي النظام');
    }
    public function single_package(Request $request,$id){
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
    public function main_socail(){
        $res = [];
        $res['instagram'] =[
            'title'=>'instagram',
            'icon'=>asset('socail/instagram.svg'),
            'path'=>'https://www.instagram.com/'
        ];
        $res['facebook'] =[
            'title'=>'facebook',
            'icon'=>asset('socail/facebook.svg'),
            'path'=>'https://www.facebook.com/'
        ];
        $res['twitter'] =[
            'title'=>'twitter',
            'icon'=>asset('socail/twitter.svg'),
            'path'=>'https://www.twitter.com/'
        ];
        $res['pinterest'] =[
            'title'=>'pinterest',
            'icon'=>asset('socail/pinterest.svg'),
            'path'=>'https://www.pinterest.com/'
        ];
        $res['linkedin'] =[
            'title'=>'linkedin',
            'icon'=>asset('socail/linkedin.svg'),
            'path'=>'https://www.linkedin.com/'
        ];
        $res['snapchat'] =[
            'title'=>'snapchat',
            'icon'=>asset('socail/snapchat.svg'),
            'path'=>'https://www.snapchat.com/'
        ];
        $res['telegram'] =[
            'title'=>'telegram',
            'icon'=>asset('socail/telegram.svg'),
            'path'=>'https://www.telegram.com/'
        ];
        $res['whatsapp'] =[
            'title'=>'whatsapp',
            'icon'=>asset('socail/whatsapp.svg'),
            'path'=>'https://www.whatsapp.com/'
        ];
        $res['youtube'] =[
            'title'=>'youtube',
            'icon'=>asset('socail/youtube.svg'),
            'path'=>'https://www.youtube.com/'
        ];
        $res['website'] =[
            'title'=>'website',
            'icon'=>asset('socail/website.svg'),
            'path'=>'https://www.website.com/'
        ];

     
        return $this->sendResponse($res,'جميع الجلسات');



    }

    
    public function single_video($id){
        $tools = Video::find($id);
        $res = new VideoResoures($tools);
        return $this->sendResponse($res,'تم ارجاع الجلسة بنجاح');
    }
}
