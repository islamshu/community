<?php

namespace App\Http\Controllers;

use App\Models\UserVideo;
use Illuminate\Http\Request;
use Validator;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function register_email(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:user_videos,email,NULL,id,date,'.today()->format('Y-m-d'),
            'date' => 'required|unique:user_videos,date,NULL,id,email,'.$request->input('email'),
        ]);
        

        // If validation fails, return the errors as JSON
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = new UserVideo();
        $user->name = $request->name;
        $user->date = today()->format('Y-m-d');
        $user->email = $request->email;
        $user->save();
        
        return response()->json(['success' => 'true'], 200);

        }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
