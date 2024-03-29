<?php

namespace App\Http\Controllers;

use App\Mail\ClaimMail;
use App\Models\Claim;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invoice as InvoiceMail;
use App\Models\Currency;
use App\Models\Payment;

class ClaimController extends Controller
{
    public function index(){
        return view('dashboard.claims.index')->with('currencies',Currency::get())->with('users',User::where('is_paid',0)->get())->with('claims',Claim::orderby('id','desc')->get());
    }
    public function payment_with_curreany(Request $request){
        $payments = Payment::whereJsonContains('currencie_ids', $request->currencyId)->get();
        return $payments;
    }
    public function store(Request $request){
        $currency = Currency::find($request->currency_id);
        $claim = new claim();
        $claim->user_id = $request->user_id;
        $claim->package_id = $request->package_id;
        $claim->payment_method = $request->payment_method;
        $claim->start_at = $request->start_at;
        $claim->save();
        $sub = new Subscription();
        $packege = Package::find($request->package_id);
        $sub->user_id = $request->user_id;
        $sub->amount = $packege->price;
        $sub->package_id = $packege->id;
        $sub->start_at = Carbon::parse($request->start_at)->format('Y-m-d');
        $sub->end_at = Carbon::parse($request->start_at)->addMonths($packege->period)->format('Y-m-d');
        $sub->status = 0;
        $sub->code = date('Ymd-His').rand(10,99);
        $sub->peroud = $packege->period;
        $sub->payment_method = $request->payment_method;
        $sub->payment_info = json_encode($request->all());
        $sub->currency_symble = $currency->symbol;
        $sub->currency_amount = $currency->value_in_dollars;
        $sub->price_with_currency = $packege->price * $currency->value_in_dollars;
        $sub->price_after_all_discount = $packege->price;

        $sub->save();
        $user = User::find($request->user_id);
        $user->start_at = Carbon::parse($request->start_at)->format('Y-m-d');
        $user->end_at = Carbon::parse($request->start_at)->addMonths($packege->period)->format('Y-m-d');
        $user->payment_method = $request->payment_method;
        $user->save();
        if ($request->payment_method == 'visa') {
            $url = 'https://api.test.paymennt.com/mer/v2.0/checkout/web';
            $data = [
                'description' => 'subscription',
                'currency' => $currency->symbol,
                'amount' => $sub->price_with_currency,
                'customer' => [
                    'firstName' => $user->name,
                    'lastName' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'items' => [
                    [
                        "name" => $packege->title,
                        "unitprice" => $sub->price_with_currency,
                        "quantity" => 1,
                        "linetotal" => $sub->price_with_currency
                    ]
                ],
                'billingAddress' => [
                    'name' => $user->name,
                    'address1' => 'Saudi Arabia Defult Address',
                    'city' => 'Riyad Defult City',
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
                $link = $data->result->redirectUrl;
            } else {
                return $data->error;
            }
        } elseif($request->payment_method == 'paypal') {
            $product = [];
            $product['items'] = [
                [
                    'name' => $packege->title,
                    'price' => $sub->price_with_currency,
                    'desc'  => $packege->description,
                    'qty' => 1
                ]
            ];
            $product['invoice_id'] = date('Ymd-His') . rand(10, 99);
            $product['invoice_description'] = "Order #{$product['invoice_id']} Bill";
            $product['return_url'] = route('success_paid_url', $sub->id);
            $product['cancel_url'] = route('cancel.payment');
            $product['total'] = $sub->price_with_currency;
            $product['currency'] = $currency->symbol;

            $paypalModule = new ExpressCheckout;
            $res = $paypalModule->setExpressCheckout($product);
            $res = $paypalModule->setExpressCheckout($product, true);
            $link = $res['paypal_link'];

        }elseif( $request->payment_method =='stripe'){
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $currency->symbol,
                            'unit_amount' => $sub->price_with_currency *100,
                            'product_data' => [
                                'name' =>  $packege->title,
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('success_paid_url', $sub->id),
                'cancel_url' => route('cancel.payment'),
            ]);
            $link = $session->url;

        }
        $claim ->paid_url = $link;
        $claim->sub_id = $sub->id;
        $claim->save();
        Mail::to($user->email)->send(new ClaimMail($sub->id,$link));

        return redirect()->back()->with(['success'=>'تم ارسال المطالبة بنجاح']);
        
    }
    public function preview_pdf($id){
        $claim = Claim::find($id);
        $sub = Subscription::find($claim->sub_id);
        $link = $claim ->paid_url;
        return view('pdf.claim')->with('sub',$sub)->with('link',$link);
    }
    public function viewmail_claim($id){
        $claim = Claim::find($id);
        $sub = Subscription::find($claim->sub_id);
        $link = $claim ->paid_url;
        return view('mail.claim')->with('claim_id',$sub->id)->with('link',$link);
    }
    
    public function destroy($id){
        $claim = Claim::find($id);
        $claim->delete();
        return redirect()->back()->with(['success'=>'تم حذف المطالبة بنجاح']);
    }
    public function resend_mail($id){
        $claim = Claim::find($id);
        $user = User::find($claim->user_id);
        if($user->is_paid == 1){
            return redirect()->back()->with(['error'=>'المستخدم قام بالدفع']);
        }
        $packege = Package::find($claim->package_id);
        $sub = Subscription::find($claim->sub_id);
        if ($sub->payment_method == 'visa') {
            $url = 'https://api.test.paymennt.com/mer/v2.0/checkout/web';
            $data = [
                'description' => 'subscription',
                'currency' => $sub->currency_symble,
                'amount' => $sub->price_with_currency,
                'customer' => [
                    'firstName' => $user->name,
                    'lastName' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'items' => [
                    [
                        "name" => $packege->title,
                        "unitprice" => $sub->price_with_currency,
                        "quantity" => 1,
                        "linetotal" => $sub->price_with_currency
                    ]
                ],
                'billingAddress' => [
                    'name' => $user->name,
                    'address1' => 'Saudi Arabia Defult Address',
                    'city' => 'Riyad Defult City',
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
                $link = $data->result->redirectUrl;
            } else {
                return $data->error;
            }
        } elseif($sub->payment_method == 'paypal') {
            $product = [];
            $product['items'] = [
                [
                    'name' => $packege->title,
                    'price' => $sub->price_with_currency,
                    'desc'  => $packege->description,
                    'qty' => 1
                ]
            ];
            $product['invoice_id'] = date('Ymd-His') . rand(10, 99);
            $product['invoice_description'] = "Order #{$product['invoice_id']} Bill";
            $product['return_url'] = route('success_paid_url', $sub->id);
            $product['cancel_url'] = route('cancel.payment');
            $product['total'] = $sub->price_with_currency;
            $product['currency'] = $sub->currency_symble;

            $paypalModule = new ExpressCheckout;
            $res = $paypalModule->setExpressCheckout($product);
            $res = $paypalModule->setExpressCheckout($product, true);
            $link = $res['paypal_link'];

        }elseif( $sub->payment_method =='stripe'){
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $sub->currency_symble,
                            'unit_amount' => $sub->price_with_currency *100,
                            'product_data' => [
                                'name' =>  $packege->title,
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('success_paid_url', $sub->id),
                'cancel_url' => route('cancel.payment'),
            ]);
            $link = $session->url;

        }
        $claim->paid_url = $link;
        $claim->save();
        Mail::to($user->email)->send(new ClaimMail($claim->sub_id,$claim->paid_url));
        return redirect()->back()->with(['success'=>'تم اعادة الارسال بنجاح']);

    }
}
