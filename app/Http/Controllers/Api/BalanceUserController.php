<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BalanceRequestResource;
use App\Models\Admin;
use App\Models\BlalnceRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\GeneralNotification;
use Pusher\Pusher;
use Validator;
class BalanceUserController extends BaseController
{
    public function payment_request(Request $request){
        $validation = Validator::make($request->all(), [
            'paid_method' => 'required',
            'amount'=>'required',
        ]);
        if ($validation->fails()) {
            return $this->sendError($validation->messages()->all());
        }
        $user = auth('api')->user();
        $mimum = get_general_value('min_withdrow');
        $withdrow = $user->total_withdrowable;
        if($request->amount > $withdrow){
            return $this->sendError('المبلغ المراد سحبه اكبر من المبلغ القابل للسحب لديك');
        }
        if($request->amount < $mimum){
            return $this->sendError('المبلغ المراد سحبه اقل من المسموح به');
        }
        
        $bankbalace = new BlalnceRequest();
        $bankbalace->paid_method = $request->paid_method;
        $bankbalace->amount = $request->amount;
        $bankbalace->status = 2;
        $bankbalace->user_id = $user->id;
        $bankbalace->payment_detiles  = get_detiles($user->id,$bankbalace->paid_method);
        $bankbalace->save();
        $user->pending_balance = $request->amount;
        $user->total_withdrowable = $withdrow - $request->amount;
        $user->save();
        $admins = Admin::whereHas(
            'roles', function($q){
                $q->where('name', 'admin');
            }
        )->get();
        $date_send = [
            'id' => $bankbalace->id,
            'name' => $user->name,
            'url' => route('withdrow_request',$bankbalace->id),
            'title' => 'طلب سحب مالي',
            'time' => $bankbalace->updated_at
        ];
        Notification::send($admins, new GeneralNotification($date_send));
        $pusher = new Pusher('ecfcb8c328a3a23a2978', '6f6d4e2b81650b704aba', '1534721', [
            'cluster' => 'ap2',
            'useTLS' => true
        ]);
        
        $pusher->trigger('notifications', 'new-notification', $date_send);
        $res = new BalanceRequestResource($bankbalace);
        return $this->sendResponse($res,'تم ارسال طلب سحب بنجاح');
        // BlalnceRequest
    }
    
}
