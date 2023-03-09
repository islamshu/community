<?php
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