<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;


use Srmklive\PayPal\Services\ExpressCheckout;



class PayPalPaymentController extends Controller

{

    public function handlePayment()

    {

        $product = [];
        $product['items'] = [
            [
                'name' => 'Nike Joyride 2',
                'price' => 112,
                'desc'  => 'Running shoes for Men',
                'qty' => 2
            ]
        ];
        $product['invoice_id'] = 1;
        $product['invoice_description'] = "Order #{$product['invoice_id']} Bill";
        $product['return_url'] = route('success.payment');
        $product['cancel_url'] = route('cancel.payment');
        $product['total'] = 224;
        $paypalModule = new ExpressCheckout;
        $res = $paypalModule->setExpressCheckout($product);
        $res = $paypalModule->setExpressCheckout($product, true);
        return redirect($res['paypal_link']);
    }



    public function paymentCancel()

    {

        dd('Your payment has been declend. The payment cancelation page goes here!');
    }
    public function cancel_payment_service()
    

    {

        dd('Your payment has been declend. The payment cancelation page goes here!');
    }

    



    public function paymentSuccess(Request $request, $id)

    {

        $paypalModule = new ExpressCheckout;

        $response = $paypalModule->getExpressCheckoutDetails($request->token);



        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

            $user = User::find($id);
            $user->is_paid = 1;
            $user->save();
            return redirect('http://community.arabicreators.com/done');
        }
        dd('Error occured!');
    }
    public function payment_success_service(Request $request, $id)

    {
        $paypalModule = new ExpressCheckout;

        $response = $paypalModule->getExpressCheckoutDetails($request->token);



        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

            $user = Order::find($id);
            $user->payment_status = 1;
            $user->start_at = today();
            $user->end_at = today()->addDays($user->all_time);

            $user->save();
            return redirect('http://community.arabicreators.com/done');
        }
        dd('Error occured!');
    }

    
}
