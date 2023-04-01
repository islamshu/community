<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\NotificationResourse;
use App\Http\Resources\UserAuthResource;
use App\Http\Resources\UserResource;
use App\Mail\WelcomRgister;
use App\Models\Answer;
use App\Models\Order;
use App\Models\Package;
use App\Models\Quastion;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserAnswer;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;
use Validator;
use Hash;
use DB;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification as ModelsNotification;

class UserController extends BaseController
{
    public function register(Request $request)
    {

        // dd($request);
        // return($request->question_id);

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'phone' => 'required|unique:users,phone',
            'have_website' => 'required',
            // 'packege_id' => 'required',
            // 'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);
            $user->phone = $request->phone;
            $user->have_website = $request->have_website;
            $user->site_url = $request->site_url;
            $user->type = 'user';
            $user->check_register = 1;
            $user->domains = $request->domains;
            $user->image = 'users/defult.png';
            $user->video = 'user_video/defult.mp4';
            $user->packege_id = $request->packege_id;
            $user->is_paid = 0;
            $user->save();
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
            Mail::to($user->email)->send(new WelcomRgister($user->name,$user->email));

            DB::commit();
            $ress = new UserAuthResource($user);
            return $this->sendResponse($ress, 'تم التسجيل بنجاح   ');
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            return $this->sendError($e, 'حدث خطأ اثناء التسجيل يرجى المحاولة لاحقا');
        }
    }
    public function my_notification()
    {
        $notification = auth('api')->user()->notifications;
        // $not = DB::table('notifications')->where('notifiable_id',auth('api')->id())->get();
        // dd($notification);
        $res = NotificationResourse::collection($notification);
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
            'time'=>$date->diffForHumans()

        ];
        return $this->sendResponse($res, 'جميع الاشعارات');
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
        if(Carbon::now() < $user->end_at && $user->is_paid == 1){
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
        try {
        $packege = Package::find($request->packege_id);
        $user->start_at = Carbon::now()->format('Y-m-d');
        $user->end_at = Carbon::now()->addMonths($packege->period)->format('Y-m-d');
        $user->payment_method = $request->payment_method;
        $user->save();
        $sub = new Subscription();
        $sub->user_id = auth('api')->id();
        $sub->amount = $packege->price;
        $sub->start_at = Carbon::now()->format('Y-m-d');
        $sub->end_at = Carbon::now()->addMonths($packege->period)->format('Y-m-d');
        $sub->status = 0;
        $sub->peroud = $packege->period;
        $sub->payment_method = $request->payment_method;
        $sub->payment_info = json_encode($request->all());
        $sub->save();
        if ($request->payment_method != 'paypal') {
            $url = 'https://api.test.paymennt.com/mer/v2.0/subscription';
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
                'startDate' => $sub->start_at,
                'endDate' => $sub->end_at,
                'sendOnHour' => 10,
                'sendEvery' => numberToText($packege->period),
                'returnUrl' => route('success_paid_url', $sub->id),
            ];
            $headers = [
                'Content-Type' => 'application/json',
                'X-PointCheckout-Api-Key' => '186dfbff90cd115d',
                'X-PointCheckout-Api-Secret' => 'mer_5cf8cbe5d3bdb5f8f8486d1412e20537ed226c92754af61fb39d33d37ac6fe2f',
            ];
            $response = Http::withHeaders($headers)->post($url, $data);
            return $response;
            $data =  json_decode($response->body());
            if ($data->success == true) {
                $ress['link'] = 'https://community.arabicreators.com';
                $ress['payment_type'] = 'visa';
                return $this->sendResponse($ress, 'تم ارسال رسالة الى بريدك الالكتروني لاكمال عملية الدفع');
            } else {
                return $this->sendError('حدث خطأ ما');
            }
        }else{
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
    public function success_paid_url(Request $request,$sub_id)
    {
        $sub = Subscription::find($sub_id);
        $sub->status = 1;
        $sub->save();
        $user = User::find($sub->user_id);
        $user->is_paid = 1;
        $user->start_at = $sub->start_at;
        $user->end_at = $sub->end_at;
        $user->payment_method = $sub->payment_method;
        $user->save();
        $res = new UserResource($user);
        $date_send = [
            'id' => $user->id,
            'name' => $user->name,
            'url' => '',
            'title' => 'تم الاشتراك بالباقة بنجاح',
            'time' => $user->updated_at
        ];
        $user->notify(new GeneralNotification($date_send));
        return redirect('https://communityapp.arabicreators.com');
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
    public function update_profile(Request $request)
    {
        $user = auth('api')->user();
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            // 'password' => 'required',
            'phone' => 'required|unique:users,phone,' . $user->id,
            'have_website' => 'required',
            // 'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->have_website = $request->have_website;
        $user->site_url = $request->site_url;
        if ($request->image != null) {
            $user->image = $request->image->store('users');
        }
        if ($request->video != null) {
            $user->video = $request->video->store('user_video');
        }
        $user->save();
        $res = new UserResource($user);
        return $this->sendResponse($res, 'البروفايل الشخصي');
    }
    public function update_password(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user = auth('api')->user();
        $user->password =  Hash::make($request->password);
        $user->save();
        $res = new UserResource(auth('api')->user());
        return $this->sendResponse($res, ' تم تغير كلمة المرور');
    }
    public function logout(Request $request)
    {
        auth('api')->user()->token()->revoke();
        return $this->sendResponse('success', 'تم تسجيل الخروج بنجاح   ');
    }
}
