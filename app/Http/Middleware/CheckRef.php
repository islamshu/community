<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CheckRef
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
        
    $response = $next($request);

    if ($request->has('ref')){
        $referral = User::where('ref_code',$request->get('ref'))->first();
        $response()->cookie('ref', $referral->id, 360 * 24 * 60);
    }

    return $response;
      }
    
        
        
        
    
    
}