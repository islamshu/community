<?php

use App\Models\GeneralInfo;
use Illuminate\Support\Facades\Http;

function get_extra($id){
    $response = Http::get('http://dashboard.arabicreators.com/api/price_extra/'.$id);
    $data =json_decode( $response->body()) ;
    if($data->code == 400){
        return 'false';
    }else{
        return $data->data;
    }
}
function get_status($stauts){
    if($stauts == 1){
        return 'مقبول';
    }elseif($stauts == 0){
        return 'مرفوض';
    }elseif($stauts  == 2){
        return 'قيد المراجعة';

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
function get_general_value($key)
{
   $general = GeneralInfo::where('key', $key)->first();
   if($general){
       return $general->value;
   }

   return '';
}