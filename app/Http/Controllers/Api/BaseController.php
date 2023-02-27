<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result  , $message){
        $response = ['success' => true , 'data' => $result, 'message' => $message,'code'=>200];
        return response()->json($response , 200)->getData(true);
    }
    public function sendErrornew( $message){
        $response = ['success' => false ,'message' => $message];
        return response()->json($response , 200);
    }

    public function sendError($error , $errorMessages = [] , $code = 200){
        $response = ['success' => false, 'message' => $error,'code'=>400];
        if (!empty($errorMessages))
            $response['data'] = $errorMessages;
        return response()->json($response , $code);
    }
}