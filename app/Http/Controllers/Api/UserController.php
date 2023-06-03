<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BankInfoResource;
use App\Http\Resources\NotificationResourse;
use App\Http\Resources\SubscriptionResource;
use App\Http\Resources\UserAuthResource;
use App\Http\Resources\UserResource;
use App\Mail\MessageEmail;
use App\Mail\Order as MailOrder;
use App\Mail\VerifyEmail;
use App\Mail\WelcomRgister;
use App\Models\Admin;
use App\Models\AffiliteUser;
use App\Models\Answer;
use App\Models\BankInfo;
use App\Models\Domians;
use App\Models\MailMessage;
use App\Models\MarkterSoical;
use App\Models\Order;
use App\Models\Package;
use App\Models\Quastion;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserAnswer;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Validator;
use Hash;
use DB;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification as ModelsNotification;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Pusher\Pusher;



class UserController extends BaseController
{
    public function afflite_info(){
        $bank = BankInfo::where('user_id',auth('api')->id())->first();
        if(!$bank){
            return $this->sendError('لا يتوفر بيانات');

        }
        $res = new BankInfoResource($bank);
        return $this->sendResponse($res, 'bank info');

    }
    public function get_statistic_for_balance(Request $request){
        $from = $request->from;
        $to = $request->to;
        // $id =220;
        $id = auth('api')->id();
        // dd($from,$to);

        if($from != null && $to != null ){
            $users = User::where('referrer_id',$id)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->whereBetween('created_at', [$from, $to])->get();
            $userspaid = User::where('referrer_id',$id)->where('is_paid',1)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->whereBetween('created_at', [$from, $to])->get();
        }else{
            $users = User::where('referrer_id',$id)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->get();
            $userspaid = User::where('referrer_id',$id)->where('is_paid',1)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->get();
        }
        $res=[
            'number_register_user'=>@$users[0]['total'] != null ? @$users[0]['total'] : 0,
            'number_paid_user'=>@$userspaid[0]['total'] != null ? @$userspaid[0]['total'] : 0,
            'balance_form_register'=>@$users[0]['total'] != null ? $users[0]['total'] * get_general_value('register_member') : 0,
            'balance_form_paid'=>@$userspaid[0]['total'] != null ? $userspaid[0]['total'] * get_general_value('register_member_paid') : 0,
        ];
        return $this->sendResponse($res, 'statistic info');

    }
    public function user_staticsta()
    {
        $id = auth('api')->id();
        $users = User::where('referrer_id',$id)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
        ->groupBy('month')
        ->get();
        $userspaid = User::where('referrer_id',$id)->where('is_paid',1)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
        ->groupBy('month')
        ->get();
    // Formatting the data for the column chart
    $chartData = [
        'labels' => [],
        'datasets' => [],
    ];
    $chartData2 = [
        'labels' => [],
        'datasets' => [],
    ];
    


    // Populate the labels array
    foreach ($users as $user) {
        $monthName = Carbon::createFromFormat('!m', $user->month)->format('F');
        $chartData['labels'][] = $monthName;
        $chartData2['labels'][] = $monthName;

    }
    foreach ($userspaid as $user) {
        $monthName = Carbon::createFromFormat('!m', $user->month)->format('F');
        $chartData['labels'][] = $monthName;
        $chartData2['labels'][] = $monthName;
    }

    // Define dataset 1
    $dataset1 = [
        'label' => 'المسجلين',
        'data' => [],
        'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
        'borderColor' => 'rgba(54, 162, 235, 1)',
        'borderWidth' => 1,
    ];

    // Define dataset 2
    $dataset2 = [
        'label' => 'الدافعين',
        'data' => [],
        'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
        'borderColor' => 'rgba(255, 99, 132, 1)',
        'borderWidth' => 1,
    ];
    $dataset3 = [
        'label' => 'اجمالي الرصيد من التسجيل',
        'data' => [],
        'backgroundColor' => 'rgba(255, 99, 111, 0.5)',
        'borderColor' => 'rgba(255, 99, 111, 1)',
        'borderWidth' => 1,
    ];

    // Populate the data arrays for each dataset
    foreach ($users as $user) {
        $dataset1['data'][] = $user->total;
        // $dataset2['data'][] =  $user->where('is_paid',1)->count();// Add your logic here to fetch data for the second dataset
    }
    foreach ($userspaid as $user) {
        $dataset2['data'][] = $user->total;
    }
    $dataset3 = [
        'label' => 'اجمالي الرصيد من التسجيل',
        'data' =>@$dataset1['data'][0] != null ? [@$dataset1['data'][0] * 5] : [0] ,
        'backgroundColor' => 'rgba(141, 99, 111, 0.5)',
        'borderColor' => 'rgba(141, 99, 111, 1)',
        'borderWidth' => 1,
    ];
    $dataset4 = [
        'label' => 'اجمالي الرصيد من الاشتراك',
        'data' => @$dataset2['data'][0] != null ? [$dataset2['data'][0] * 10]  : [0],
        'backgroundColor' => 'rgba(200, 99, 111, 0.5)',
        'borderColor' => 'rgba(200, 99, 111, 1)',
        'borderWidth' => 1,
    ];

    // Add the datasets to the chart data
    $chartData['datasets'][] = $dataset1;
    $chartData['datasets'][] = $dataset2;
    $chartData2['datasets'][] = $dataset3 ;
    $chartData2['datasets'][] = $dataset4 ;
    $res = [
        'chart_1'=>$chartData,
        'chart_2'=>$chartData2
    ];
    return $this->sendResponse($res,'تم ارجاع البيانات');

    

    }
    public function check_user_register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'phone' => $request->phone != null ? 'unique:users,phone' : '',
            // 'have_website' => 'required',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        return $this->sendResponse('success', true);
    }
    public function main_info_for_user(){
        $user = auth('api')->user();
        $res = [
            'is_paid'=>$user->is_paid,
            'is_verified'=>$user->email_verified_at == null ? 0 : 1,
            'is_able_to_affiliate'=>$user->is_able_affilete,
            'is_have_social_media'=>is_have_social_media()
        ];
        return $this->sendResponse($res,'تم ارجاع البيانات');
        
    }

    public function statistic()
    {
        $userr = auth('api')->user();
        if($userr->is_able_affilete != 1){
            if($userr->is_able_affilete == 2){
                return $this->sendError('حسابك قيد المتابعة');
            }else{
                return $this->sendError('حسابك مرفوض من التسويق بعمولة');
            }
        }
        $user = auth('api')->id();
        $aff = AffiliteUser::where('user_id', $user)->first();
        if ($aff) {
            $number_show = $aff->show;
        } else {
            $number_show = 0;
        }
        $register_user = User::where('referrer_id', $user)->count();
        $paid_user = User::where('referrer_id', $user)->where('is_paid', 1)->count();
        $bank = BankInfo::where('user_id',$user)->first();
        $pending = User::find($user)->pending_balance;
        $res = [
            'number_show' => $number_show,
            'register_user' => $register_user,
            'paid_user' => $paid_user,
            'total_balance' => auth('api')->user()->total_balance,
            'withdrawable_balance' => auth('api')->user()->total_withdrowable,
            'pending_balance'=> $pending == null ? 0 : $pending,
            'type'=>json_decode($bank->type),
            'minumam_value_to_withdraw'=>get_general_value('min_withdrow')
        ];
        return $this->sendResponse($res, 'statistic');
    }

    public function my_affilite($code)
    {
        $aff = User::where('ref_code', $code)->first();
        $checkaff = AffiliteUser::where('user_id', $aff->id)->first();
        if ($checkaff) {
            $checkaff->show += 1;
            $checkaff->save();
        } else {
            $ch = new AffiliteUser();
            $ch->user_id = $aff->id;
            $ch->show = 1;
            $ch->save();
        }
        $url = 'https://community.arabicreators.com/?ref=' . $code;
        return redirect($url);

        // return new Response('Cookie has been set.')->withCookie($cookie);

    }


    public function register(Request $request)
    {

        // dd($request);
        // return($request->question_id);

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'phone' => $request->phone != null ? 'unique:users,phone' : '',
            'domains' => 'required',
            // 'packege_id' => 'required',
            // 'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        // return ;
        $doms = json_encode(($request->domains));
        $array_dom = [];
        foreach (json_decode($doms) as $dom) {
            $dom = Domians::where('title',$dom)->first();
            array_push($array_dom,$dom->id);  
        }


        // return $this->sendResponse($request->domains, 'تم التسجيل بنجاح   ');

        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;

            $user->domains =json_encode($array_dom);
            $user->password =  Hash::make($request->password);
            $user->phone = $request->phone;
            $user->have_website = $request->have_website;
            $user->site_url = $request->site_url;
            $user->type = 'user';
            $user->check_register = 1;
            $user->image = 'users/defult.png';
            $user->video = 'user_video/defult.mp4';
            $user->packege_id = $request->packege_id;
            $user->is_paid = 0;
            if ($request->ref_code != null) {
                $reffer = User::where('ref_code', $request->ref_code)->first();
                if ($reffer) {
                    $user->referrer_id = $reffer->id;
                } else {
                    $user->referrer_id = null;
                }
            }

            $user->save();
            if ($user->referrer_id != null) {
                $refref = User::find($user->referrer_id);
                // if($reffer->is_able_affilete == 1){
                    if ($refref->is_paid) {
                        $refref->total_balance += get_general_value('register_member');
                        $refref->total_withdrowable += get_general_value('register_member');
                        $refref->save();
                    // }
                }
                
            }
            // dd($user);

            $date = json_encode(($request->question_id));
            $date2 = json_encode(($request->answer_id));
            foreach (json_decode(@$date, @$date2)  as $key => $q) {
                if ($q == null) {
                    continue;
                }
                $ans = new UserAnswer();
                $ans->user_id = $user->id;
                $ans->question = Quastion::find((int)json_decode($date)[$key])->title;
                if (is_numeric(json_decode($date2)[$key])) {
                    $ans->answer = Answer::find(json_decode($date2)[$key])->title;
                } else {
                    $ans->answer = json_decode($date2)[$key];
                }
                $ans->save();
            }
            $date_send = [
                'id' => $user->id,
                'name' => $user->name,
                'url' => '',
                'title' => 'اهلا وسهلا بك في مجتمعنا !',
                'time' => $user->updated_at
            ];
            $user->notify(new GeneralNotification($date_send));
            Mail::to($user->email)->send(new WelcomRgister($user->name, $user->email));
            $enc = encrypt($user->id);
            $url = route('send_email.verfy', $enc);
            Mail::to($request->email)->send(new VerifyEmail($url));
            DB::commit();
            $ress = new UserAuthResource($user);
            return $this->sendResponse($ress, 'تم التسجيل بنجاح   ');
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            return $this->sendError($e, 'حدث خطأ اثناء التسجيل يرجى المحاولة لاحقا');
        }
    }
    public function user_profile($name)
    {

        // Create a new image with the first letter of the name
        $image = imagecreatetruecolor(200, 200);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        $black = imagecolorallocate($image, 0, 0, 0);
        $font = public_path('fonts/OpenSans-Regular.ttf');
        imagettftext($image, 100, 0, 100, 110, $black, $font, strtoupper(substr($name, 0, 1)));

        // Output the image as a response
        ob_start();
        imagepng($image);
        $image_data = ob_get_clean();
        return Response::make($image_data, 200, ['Content-Type' => 'image/png']);
    }
    public function edit_soical(Request $request)
    {
        $user = auth('api')->user();
        $social = $user->soical;
        if ($social == null) {
            $social = new MarkterSoical();
            if($request->instagram != null){
                $social->instagram ='https://www.instagram.com/'. $request->instagram;
            }
            if($request->facebook != null){
                $social->facebook = 'https://www.facebook.com/'.$request->facebook;
            }if($request->twitter != null){
                $social->twitter = 'https://www.twitter.com/'.$request->twitter;
            }if($request->pinterest != null){
                $social->pinterest ='https://www.pinterest.com/'. $request->pinterest;
            }if($request->snapchat != null){
                $social->snapchat = 'https://www.snapchat.com/'.$request->snapchat;
            }if($request->linkedin != null){
                $social->linkedin = 'https://www.linkedin.com/'.$request->linkedin;
            }if($request->website != null){
                $social->website = $request->website;
            }if($request->podcast != null){
                $social->podcast = $request->podcast;
            }if($request->ecommerce != null){
                $social->ecommerce = $request->ecommerce;
            }if($request->whatsapp != null){
                $social->whatsapp = 'https://wa.me/'.$request->whatsapp;
            }if($request->telegram != null){
                $social->telegram = 'https://t.me/'.$request->telegram;
            }if($request->youtube != null){
                $social->youtube = 'https://www.youtube.com/'.$request->youtube;
            }

            $social->followers_number = $request->followers_number;
            $social->user_id = $user->id;
            $social->save();
        } else {
            $social->instagram ='https://www.instagram.com/'. $request->instagram;
            $social->facebook = 'https://www.facebook.com/'.$request->facebook;
            $social->twitter = 'https://www.twitter.com/'.$request->twitter;
            $social->pinterest ='https://www.pinterest.com/'. $request->pinterest;
            $social->snapchat = 'https://www.snapchat.com/'.$request->snapchat;
            $social->linkedin = 'https://www.linkedin.com/'.$request->linkedin;
            $social->website = $request->website;
            $social->podcast = $request->podcast;
            $social->ecommerce = $request->ecommerce;
            $social->whatsapp = 'https://wa.me/'.$request->whatsapp;
            $social->telegram = 'https://t.me/'.$request->telegram;
            $social->youtube = 'https://www.youtube.com/'.$request->youtube;
            $social->followers_number = $request->followers_number;
           
            $social->save();
        }
        return $this->sendResponse('success', 'تم تعديل السوشل ميديا');
    }
    public function my_notification()
    {
        $notification = auth('api')->user()->unreadNotifications;
        // $not = DB::table('notifications')->where('notifiable_id',auth('api')->id())->get();
        // dd($notification);
        $res['data'] = NotificationResourse::collection($notification);
        $res['number'] = auth('api')->user()->unreadNotifications->count();

        return $this->sendResponse($res, 'جميع الاشعارات');
    }
    public function show_notification($id)
    {
        $notification = ModelsNotification::find($id);
        $notification->read_at = Carbon::now();
        $notification->save();
        $not = DB::table('notifications')->where('id', $id)->first();
        // return json_decode($not->data)->title;
        // return (string)json_encode($notification->data['title']);
        // $no = json_decode($notification);
        // $res = new NotificationResourse($notification);
        $date = Carbon::parse($not->created_at); // now date is a carbon instance

        $res = [
            'id' => $not->id,
            'title' => json_decode($not->data)->title,
            'url' => json_decode($not->data)->url,
            'is_read' => $not->read_at != null ? 1 : 0,
            'created_at' => $not->created_at,
            'time' => $date->diffForHumans()

        ];
        return $this->sendResponse($res, 'تم قراءة الاشعار');
    }
    public function pay(Request $request)
    {
        $user = auth('api')->user();
        if ($user->is_paid == 1) {
            return $this->sendError('المستخدم دافع !');
        }
        $validation = Validator::make($request->all(), [
            'packege_id' => 'required',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user = auth('api')->user();
        $user->packege_id = $request->packege_id;
        $user->save();
        $packege = Package::find($request->packege_id);
        $product = [];
        $product['items'] = [
            [
                'name' => $packege->title,
                'price' => $packege->price,
                'desc'  => $packege->description,
                'qty' => 1
            ]
        ];
        $product['invoice_id'] = date('Ymd-His') . rand(10, 99);
        $product['invoice_description'] = "Order #{$product['invoice_id']} Bill";
        $product['return_url'] = route('success.payment', $user->id);
        $product['cancel_url'] = route('cancel.payment');
        $product['total'] = $packege->price;
        $paypalModule = new ExpressCheckout;
        $res = $paypalModule->setExpressCheckout($product);
        $res = $paypalModule->setExpressCheckout($product, true);

        $ress['link'] = $res['paypal_link'];
        $ress['payment_type'] = 'paypal';
        return $this->sendResponse($ress, 'اضغط على الزر للدفع');
    }
    public function pay_user(Request $request)
    {
        $user = auth('api')->user();
        if($user->email_verified_at == null){
            return $this->sendError('يجب توثيق حسابك قبل الدفع');
        }
        if (Carbon::now() < $user->end_at && $user->is_paid == 1) {
            return $this->sendError('انت بالفعل مشترك');
        }
        $validation = Validator::make($request->all(), [
            'packege_id' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'payment_method' => 'required'
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }

        $packege = Package::find($request->packege_id);
        $user->start_at = Carbon::now()->format('Y-m-d');
        $user->end_at = Carbon::now()->addMonths($packege->period)->format('Y-m-d');
        $user->payment_method = $request->payment_method;
        $user->save();
        $sub = new Subscription();
        $sub->user_id = auth('api')->id();
        $sub->amount = $packege->price;
        $sub->package_id = $packege->id;
        $sub->start_at = Carbon::now()->format('Y-m-d');
        $sub->end_at = Carbon::now()->addMonths($packege->period)->format('Y-m-d');
        $sub->status = 0;
        $sub->code = date('Ymd-His').rand(10,99);

        $sub->peroud = $packege->period;
        $sub->payment_method = $request->payment_method;
        $sub->payment_info = json_encode($request->all());
        $sub->save();
        if ($request->payment_method != 'paypal') {
            $url = 'https://api.test.paymennt.com/mer/v2.0/checkout/web';
            $data = [
                'description' => 'subscription',
                'currency' => 'AED',
                'amount' => $packege->price,
                'customer' => [
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ],
                'items' => [
                    [
                        "name" => $packege->title,
                        "unitprice" => $packege->price,
                        "quantity" => 1,
                        "linetotal" => $packege->price
                    ]
                ],
                'billingAddress' => [
                    'name' => $user->name,
                    'address1' => $request->address,
                    'city' => $request->address,
                    'country' => 'AE',
                ],
                'startDate' => $sub->start_at,
                'endDate' => $sub->end_at,
                'sendOnHour' => 10,
                'sendEvery' => numberToText($packege->period),
                'returnUrl' => route('success_paid_url', $sub->id),
                'orderId' => now(),
                'requestId' => now(),
            ];
            $headers = [
                'Content-Type' => 'application/json',
                'X-PointCheckout-Api-Key' => '186dfbff90cd115d',
                'X-PointCheckout-Api-Secret' => 'mer_5cf8cbe5d3bdb5f8f8486d1412e20537ed226c92754af61fb39d33d37ac6fe2f',
            ];
            $response = Http::withHeaders($headers)->post($url, $data);
            $data =  json_decode($response->body());
            if ($data->success == true) {
                $ress['link'] = $data->result->redirectUrl;
                $ress['payment_type'] = 'visa';
                return $this->sendResponse($ress, 'سيتم تحويلك الى صفحة الدفع . يرجى الانتظار ');
            } else {
                return $this->sendError('حدث خطأ ما : ' . $data->error);
            }
        } else {
            $packege = Package::find($request->packege_id);
            $product = [];
            $product['items'] = [
                [
                    'name' => $packege->title,
                    'price' => $packege->price,
                    'desc'  => $packege->description,
                    'qty' => 1
                ]
            ];
            $product['invoice_id'] = date('Ymd-His') . rand(10, 99);
            $product['invoice_description'] = "Order #{$product['invoice_id']} Bill";
            $product['return_url'] = route('success_paid_url', $sub->id);
            $product['cancel_url'] = route('cancel.payment');
            $product['total'] = $packege->price;
            $paypalModule = new ExpressCheckout;
            $res = $paypalModule->setExpressCheckout($product);
            $res = $paypalModule->setExpressCheckout($product, true);

            $ress['link'] = $res['paypal_link'];
            $ress['payment_type'] = 'paypal';
            return $this->sendResponse($ress, 'سيتم تحويلك الى صفحة الدفع . يرجى الانتظار ');
        }
    }
    public function subscription()
    {
        $subs = Subscription::where('status', 1)->where('user_id', auth('api')->id())->get();
        $res = SubscriptionResource::collection($subs);
        return $this->sendResponse($res, 'جميع الفواتير');
    }
    public function get_subscription_by_id($id)
    {
        $subs = Subscription::find($id);
        $res = new SubscriptionResource($subs);
        return $this->sendResponse($res, 'بيانات الفاتورة');
    }
    public function set_bank_info(Request $request){
       $types = explode(',',$request->type);
       $array =[];
       foreach($types as $type){
        array_push($array,$type);
       }
        // return $request->persionID.' ' .'islam';
        $validation = Validator::make($request->all(), [
            'type' => 'required',
            'paypal_email' => in_array('paypal',$array)  ? 'required' :'',
            'fullname' =>   in_array('westron',$array) ? 'required' :'',
            // 'persionID' => in_array('westron',$array) ? 'required' :'',
            // 'Idimage' => in_array('westron',$array) ? 'required' :'',
            'fullnameArabic' =>   in_array('westron',$array) ? 'required' :'',
            'counrty' => in_array('westron',$array) ? 'required' :'',
            'city' => in_array('westron',$array) ? 'required' :'',
            'phone' => in_array('westron',$array) ? 'required' :'',
            'bank_name' => in_array('bank',$array) ? 'required' :'',
            'ibanNumber' =>in_array('bank',$array) ? 'required' :'',
            'owner_name' => in_array('bank',$array) ? 'required' :'',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user = auth('api')->user();
        $socal = is_have_social_media();
       
        if($socal == 0){
            return $this->sendError('يجب ان يحتوي حسابك على رابط او اكثر لحساباتك السوشل ميديا');
        }
        $bankInfo = BankInfo::where('user_id',auth('api')->id())->first();
        if(!$bankInfo){
            $bankInfo = new BankInfo();
        }
        if($bankInfo->status == 2){
            return $this->sendError('طلبك معلق يرجى الانتظار لحين قبول الادارة');
        }
        if($bankInfo->status == 1){
            $user->is_able_affilete = 1;
            $bankInfo->status = 1;
            $user->save();
        }else{
            $user->is_able_affilete = 2;
            $bankInfo->status = 2;
        }
        $user->save();
        $bankInfo->type = json_encode($array);
        $bankInfo->paypal_email = $request->paypal_email =='undefined' ? null : $request->paypal_email;
        $bankInfo->fullname = $request->fullname =='undefined' ? null : $request->fullname;
        $bankInfo->fullnameArabic = $request->fullnameArabic =='undefined' ? null : $request->fullnameArabic;
        $bankInfo->counrty = $request->counrty =='undefined' ? null : $request->counrty;
        $bankInfo->city = $request->city =='undefined' ? null : $request->city;
        $bankInfo->phone = $request->phone =='undefined' ? null : $request->phone;
        // $bankInfo->persionID = $request->persionID =='undefined' ? null : $request->persionID;
        // if($request->Idimage ){
        //     $bankInfo->Idimage = $request->Idimage->store('bank_info');
        // }
        $bankInfo->bank_name = $request->bank_name =='undefined' ? null : $request->bank_name;
        $bankInfo->ibanNumber = $request->ibanNumber =='undefined' ? null : $request->ibanNumber;
        $bankInfo->owner_name = $request->owner_name =='undefined' ? null : $request->owner_name;
        $bankInfo->user_id = auth('api')->id();
        $bankInfo->save();
        $admins = Admin::whereHas(
            'roles', function($q){
                $q->where('name', 'admin');
            }
        )->get();
        $date_send = [
            'id' => $bankInfo->id,
            'name' => $bankInfo->user->name,
            'url' => route('show_bank_info',$bankInfo->id),
            'title' => 'طلب تسويق بالعمولة',
            'time' => $bankInfo->updated_at
        ];
        Notification::send($admins, new GeneralNotification($date_send));
        $pusher = new Pusher('ecfcb8c328a3a23a2978', '6f6d4e2b81650b704aba', '1534721', [
            'cluster' => 'ap2',
            'useTLS' => true
        ]);
        $messagecode =new  MailMessage();
            $messagecode->user_id = $user->id;
            $messagecode->title = 'طلب تسويق بالعمولة';
            $messagecode->message = 'تم ارسال طلب تسويق بالعمولة بنجاح';
            $messagecode->save();
            $mess=[
                'title'=>'طلب تسويق بالعمولة',
                'message' =>  'تم ارسال طلب تسويق بالعمولة بنجاح',
            ];
            Mail::to($user->email)->send(new MessageEmail($mess));
        $pusher->trigger('notifications', 'new-notification', $date_send);
        $res = new BankInfoResource($bankInfo);
        return $this->sendResponse($res, 'تمت الاضافة بنجاح، سيتم مراجعة طلبك خلال ٢٤ ساعة');
    }


    public function success_paid_url(Request $request, $sub_id)
    {
        $sub = Subscription::find($sub_id);
        $sub->status = 1;
        $sub->save();
        $user = User::find($sub->user_id);
        $user->is_paid = 1;
        $user->start_at = $sub->start_at;
        $user->end_at = $sub->end_at;
        $user->payment_method = $sub->payment_method;
        if ($user->ref_code == null) {
            $user->ref_code = $user->name . '_' . now()->timestamp;
        }
        $user->save();
        if ($user->referrer_id != null) {
            $refref = User::find($user->referrer_id);
            // if($refref->is_able_affilete == 1){
            if ($refref->is_paid) {
                $refref->total_balance += get_general_value('register_member_paid');
                $refref->total_withdrowable += get_general_value('register_member_paid');
                $refref->save();
            // }
        }
        }
        $res = new UserResource($user);
        $date_send = [
            'id' => $user->id,
            'name' => $user->name,
            'url' => '',
            'title' => 'تم الاشتراك بالباقة بنجاح',
            'time' => $user->updated_at
        ];
        $user->notify(new GeneralNotification($date_send));

        Mail::to($user->email)->send(new MailOrder($user->name, $sub, $user->is_finish));

        return redirect('https://community.arabicreators.com/profile');
        return $this->sendResponse($res, 'تم الاشتراك بنجاح');
    }
    public function pay_service(Request $request)
    {
        $user = auth('api')->user();

        $validation = Validator::make($request->all(), [
            'service_slug' => 'required',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $service_controller = new HomeController;
        $data = $service_controller->single_service($request->service_slug);
        $res = ($data);
        $code =  $res->code;
        if ($code == 400) {
            return $this->sendError('الخدمة غير متوفرة');
        } else {
            $service =  $data->data;
            $extratime = 0;
            $extraprice = 0;
            $extraarray = [];

            if ($request->extra) {
                $extra = explode(',', $request->extra);
                // dd($extra);
                foreach ($extra as $ex) {
                    $ex = str_replace(['[', ']', '"'], '', $ex);
                    $get_extra = get_extra($ex);
                    if ($get_extra == 'false') {
                        return $this->sendError('التطويرة غير متوفرة');
                    } else {
                        $extratime += $get_extra->time;
                        $extraprice += $get_extra->price;
                        array_push($extraarray, $get_extra->id);
                    }
                }
            }

            $order = new Order();
            $order->user_id = auth('api')->id();
            $order->service_time = $service->time;
            $order->service_id = $service->id;
            $order->service_price = $service->price;
            $order->all_time =  $order->service_time + $extratime;
            $order->all_price =  $order->service_price + $extraprice;
            $order->payment_status = 0;
            $order->code = date('Ymd-His').rand(10,99);
            $order->extra = json_encode($extraarray);
            $order->save();
            $product = [];
            $product['items'] = [
                [
                    'name' => $service->title,
                    'price' => $order->all_price,
                    'desc'  => $service->description,
                    'qty' => 1
                ]
            ];
            $product['invoice_id'] = date('Ymd-His') . rand(10, 99);
            $product['invoice_description'] = "Order #{$product['invoice_id']} Bill";
            $product['return_url'] = route('success.payment_service', $order->id);
            $product['cancel_url'] = route('cancel.payment_servicet');
            $product['total'] = $order->all_price;
            $paypalModule = new ExpressCheckout;
            $res = $paypalModule->setExpressCheckout($product);
            $res = $paypalModule->setExpressCheckout($product, true);

            $ress['link'] = $res['paypal_link'];
            $ress['payment_type'] = 'paypal';
            return $this->sendResponse($ress, 'اضغط على الزر للدفع');
        }
    }


    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->check_register == 0) {

                return $this->sendError('لم يتم قبولك بعد . ');
            }
            if (Hash::check($request->password, $user->password)) {
                $res = new UserAuthResource($user);
                return $this->sendResponse($res, 'تم تسجيل الدخول بنجاح');
            } else {
                $res = 'كلمة المرور غير صحيحة';
                return $this->sendError($res);
            }
        } else {
            $res = 'لم يتم العثور على المستخدم';
            return $this->sendError($res);
        }
    }
    public function profile()
    {
        $res = new UserResource(auth('api')->user());
        return $this->sendResponse($res, 'البروفايل الشخصي');
    }
    public function update_image(Request $request){
        $user = auth('api')->user();
        $validation = Validator::make($request->all(), [
            'image' => 'required',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user->image = $request->image->store('users');
        $user->save();
        $res = new UserResource($user);
        return $this->sendResponse($res, 'تم تعديل الملف الشخصي');
    }
    public function update_profile(Request $request)
    {
        $user = auth('api')->user();
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            // 'password' => 'required',
            // 'phone' => 'required|unique:users,phone,' . $user->id,
            // 'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user->email = $request->email;
        $user->name = $request->name;
        if ($request->phone != null) {
            $user->phone = $request->phone;
        }
        // $user->have_website = $request->have_website;
        if ($request->user_url != null) {
            $user->site_url = $request->user_url;
        }
        if ($request->image != null) {
            $user->image = $request->image->store('users');
        }
        if ($request->video != null) {
            $user->video = $request->video->store('user_video');
        }
        $array_dom = [];
        $items= explode(',',$request->domains);
        foreach ($items as $dom) {
            $dom = Domians::where('title',$dom)->first();
            if(!$dom){
                continue;
            }
            array_push($array_dom,$dom->id);  
        }
        $user->domains =json_encode($array_dom); 
        $user->save();
        $res = new UserResource($user);
        return $this->sendResponse($res, 'البروفايل الشخصي');
    }
    public function update_password(Request $request)
    {

        $user = auth('api')->user();

        $validation = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        if (Hash::check($request->old_password, $user->password)) {

            $user->password =  Hash::make($request->password);
            $user->save();
            $res = new UserResource(auth('api')->user());
            return $this->sendResponse($res, ' تم تغير كلمة المرور');
        } else {
            $errror = [];
            array_push($errror, 'كلمة المرور القديمة غير صحيحة');
            return $this->sendError($errror);
        }
    }
    public function logout(Request $request)
    {
        auth('api')->user()->token()->revoke();
        return $this->sendResponse('success', 'تم تسجيل الخروج بنجاح   ');
    }
}
