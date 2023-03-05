<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserAuthResource;
use App\Http\Resources\UserResource;
use App\Models\Answer;
use App\Models\Package;
use App\Models\Quastion;
use App\Models\User;
use App\Models\UserAnswer;
use Validator;
use Hash;
use DB;
use Srmklive\PayPal\Services\ExpressCheckout;

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
            'packege_id'=>'required',
            'site_url' => $request->have_website == 1 ? 'required' : '',
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
        $user->image = 'users/defult.png';
        $user->video = 'user_video/defult.mp4';
        $user->packege_id = $request->packege_id;
        $user->is_paid = 0;
        $user->save();
        
        // $res = new UserResource($user);
        $date = (($request->question_id));
        $date2 = (($request->answer_id));
        foreach (json_decode(@$date , @$date2)  as $key => $q) {
            if($q == null ){
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
        DB::commit();
        return $this->sendResponse($ress, 'اضغط على الزر للدفع');
    } catch (\Exception $e) {
        DB::rollback();
        return $e;
    return $this->sendError($e,'حدث خطأ اثناء التسجيل يرجى المحاولة لاحقا');  
        }
    }
    public function pay(Request $request){
        $user = auth('api')->user();
        if($user->is_paid == 1){
            return $this->sendError('المستخدم دافع !');
        }
        $validation = Validator::make($request->all(), [          
            'packege_id'=>'required',
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
    public function update_profile(Request $request){
        $user = auth('api')->user();
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            // 'password' => 'required',
            'phone' => 'required|unique:users,phone,'.$user->id,
            'have_website' => 'required',
            'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->have_website = $request->have_website;
        $user->site_url = $request->site_url;
        if($request->image != null){
            $user->image = $request->image->store('users');
        }
        if($request->video != null){
            $user->video = $request->video->store('user_video');
        }
        $user->save();
        $res = new UserResource($user);
        return $this->sendResponse($res, 'البروفايل الشخصي');

    }
    public function update_password(Request $request){
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
