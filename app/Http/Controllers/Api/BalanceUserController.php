<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Validator;
class BalanceUserController extends BaseController
{
    public function send_request(Request $request){
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
        $bankbalace->payment_detiles  = get_detiles($user,$bankbalace->paid_method);
        $bankbalace->save();
        $user->pending_balance = $request->amount;
        $user->total_withdrowable = $withdrow - $request->amount;
        $user->save();
        return $this->sendResponse('test','تم ارسال طلب سحب بنجاح');
        // BlalnceRequest
    }
    
}
