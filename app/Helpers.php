<?php

use App\Models\BankInfo;
use App\Models\GeneralInfo;
use Illuminate\Support\Facades\Http;
use Pusher\Pusher;

function get_extra($id)
{
    $response = Http::get('http://dashboard.arabicreators.com/api/price_extra/' . $id);
    $data = json_decode($response->body());
    if ($data->code == 400) {
        return 'false';
    } else {
        return $data->data;
    }
}
function is_have_social_media(){
    $exist = auth('api')->user()->soical_new()->exists();
    if($exist == true){
        return 1;
    }else{
        return 0;
    }
}
function is_have_social_media_old(){
    $user = auth('api')->user();
    $socal= $user->soical()->exists(); 
       
    if($socal == false){
        return 0;
    }else{
        if($user->soical->instagram != null ||
        $user->soical->facebook != null ||
        $user->soical->twitter != null ||
        $user->soical->pinterest != null ||
        $user->soical->snapchat != null ||
        $user->soical->linkedin != null ||
        $user->soical->podcast != null ||
        $user->soical->website != null ||
        $user->soical->ecommerce != null ||
        $user->soical->telegram != null ||
        $user->soical->youtube != null ||
        $user->soical->whatsapp != null  ){
            return 1 ;
        }else{
            return 0;
        }
    }
}
function get_status($stauts)
{
    if ($stauts == 1) {
        return 'مقبول';
    } elseif ($stauts == 0) {
        return 'مرفوض';
    } elseif ($stauts  == 2) {
        return 'قيد المراجعة';
    }
}
function get_status_button($stauts)
{
    if ($stauts == 1) {
        return 'success';
    } elseif ($stauts == 0) {
        return 'danger';
    } elseif ($stauts  == 2) {
        return 'warning';
    }
}
function numberToText($number)
{
    $text = '';

    switch ($number) {
        case 1:
            $text = 'MONTH';
            break;
        case 2:
            $text = 'TWO_MONTHS';
            break;
        case 3:
            $text = 'THREE_MONTHS';
            break;
        case 4:
            $text = 'FOUR_MONTHS';
            break;
        case 5:
            $text = 'FIVE_MONTHS';
            break;
        case 6:
            $text = 'SIX_MONTHS';
            break;
        case 7:
            $text = 'SEVEN_MONTHS';
            break;
        case 8:
            $text = 'EIGHT_MONTHS';
            break;
        case 9:
            $text = 'NINE_MONTHS';
            break;
        case 10:
            $text = 'TEN_MONTHS';
            break;
        case 11:
            $text = 'ELEVEN_MONTHS';
            break;
        case 12:
            $text = 'YEAR';
            break;
        default:
            $text = 'INVALID_NUMBER';
            break;
    }

    return $text;
}
function send_message($data){
    $options = array(
        'cluster' => env('PUSHER_APP_CLUSTER2'),
        'encrypted' => true
    );
    $pusher = new Pusher(
        env('PUSHER_APP_KEY2'),
        env('PUSHER_APP_SECRET2'),
        env('PUSHER_APP_ID2'), 
        $options
    );
    $pusher->trigger('chat-user', 'chat_user', $data);
}
function get_user_status($user){
    if($user->is_paid == 0 && $user->is_finish == 0){
      return ' <button class="btn btn-info">مستخدم جديد</button>';
    }
    if($user->is_paid == 0 &&  $user->is_finish == 1){
        return ' <button class="btn btn-warning"> منتهي الاشتراك</button>';
    }
    if($user->is_paid == 1  && $user->is_free == 0){
        return ' <button class="btn btn-primary">نشط </button>';
    }
    if($user->is_paid == 1  && $user->is_free == 1){
        return ' <button class="btn btn-success">نشط مجاني </button>';
    }
}
function get_general_value($key)
{
    $general = GeneralInfo::where('key', $key)->first();
    if ($general) {
        return $general->value;
    }

    return '';
}
function get_detiles($user_id, $payment)
{
    $bank  = BankInfo::where('user_id', $user_id)->first();
    $detiles = [];
    $bankl=[];


    if ($payment == 'paypal') {
        array_push($detiles, $bankl['paypal_email'] = $bank->paypal_email);
    } elseif ($payment == 'bank') {
        array_push($detiles, $bankl['bank_name'] = $bank->bank_name);
        array_push($detiles, $bankl['iban_number'] = $bank->ibanNumber);
        array_push($detiles, $bankl['owner_name'] = $bank->owner_name);
    } elseif ($payment == 'westron') {
        array_push($detiles, $bankl['full_name'] = $bank->fullname);
        // array_push($detiles, $bankl['personID'] = $bank->persionID);
        array_push($detiles, $bankl['fullnameArabic'] = $bank->fullnameArabic);
        array_push($detiles, $bankl['counrty'] = $bank->counrty);
        array_push($detiles, $bankl['city'] = $bank->city);
        array_push($detiles, $bankl['phone'] = $bank->phone);
        // array_push($detiles, $bankl['Idimage'] = asset('uploads/' . $bank->Idimage));
    }
    // dd($bankl);
    return json_encode($bankl);
}
function get_payment($payment){
    if($payment == 'paypal'){
        return 'PayPal';
    }elseif($payment == 'visa'){
        return 'Visa';
    }
}
function get_withdrow_detiles($bank, $elemnt)
{
    return($bank->$elemnt);
}
