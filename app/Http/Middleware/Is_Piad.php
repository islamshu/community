<?php

namespace App\Http\Middleware;

use Closure;

class Is_Piad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
        if (auth('api')->check()) {
            if(auth('api')->user()->is_paid == 1){
                return $next($request);
            }else{
                $response = ['success' => false, 'message' => 'يرجى الدفع اولا  ','code'=>400];
        if (!empty($errorMessages))
            $response['data'] = $errorMessages;
        return response()->json($response , 200);
            }
        }
        $response = ['success' => false, 'message' => 'يرجى تسجيل الدخول اولا','code'=>400];
        if (!empty($errorMessages))
            $response['data'] = $errorMessages;
        return response()->json($response , 200);
      }
    
        
        
        
    
    
}