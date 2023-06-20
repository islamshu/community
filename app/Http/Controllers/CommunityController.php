<?php

namespace App\Http\Controllers;
use App\GoogleMeetService;
use App\Models\Community;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(){
        return view('dashboard.communites.index')->with('communites',Community::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.communites.create');
    }
    public function edit($id){
        return view('dashboard.communites.edit')->with('community',Community::find($id));
    }
    public function show($id){
        return view('dashboard.communites.show')->with('community',Community::find($id));
    }
    public function update(Request $request,$id){
        $googleAPI = new GoogleMeetService();
        $community = Community::find($id);
        $event = $googleAPI->delete($community->meeting_id);
        $start =  Carbon::parse($request->meeting_date);
        $endTime = Carbon::parse($request->meeting_date)->addMinute($request->meeting_time);
        $emails = ['islamshu12@gmail.com'];
        $event = $googleAPI->createMeet($request->title, $request->title, $start, $endTime, $emails);
        $community->title = $request->title;
        if($request->image != null){
            $community->image = $request->image->store('community');
        }
        $community->meeting_date = $request->meeting_date;
        $community->meeting_url =  $event->hangoutLink;
        $community->meeting_id = $event->getId();
        $community->meeting_time = $request->meeting_time;
        $community->peroid_number = $request->peroid_number;
        $community->peroid_type = $request->peroid_type;
        $community->meeting_end = $endTime;
        $community->save();
        return redirect()->route('communites.index')->with(['success'=>'تم تعديل المجتمع بنجاح المجتمع بنجاح']);
    }
    public function store(Request $request){

        $googleAPI = new GoogleMeetService();
        $start =  Carbon::parse($request->meeting_date);
        $endTime = Carbon::parse($request->meeting_date)->addMinute($request->meeting_time);
        $emails = ['islamshu12@gmail.com'];
        // dd($endTime);
        $event = $googleAPI->createMeet($request->title, $request->title, $start, $endTime, $emails);
        // dd($event,$request);
        $community = new Community();
        $community->title = $request->title;
        $community->image = $request->image->store('community');
        $community->meeting_date = $request->meeting_date;
        $community->meeting_url =  $event->hangoutLink;
        $community->meeting_id = $event->getId();
        $community->meeting_time = $request->meeting_time;
        $community->peroid_number = $request->peroid_number;
        $community->peroid_type = $request->peroid_type;
        $community->meeting_end = $endTime;
        $community->save();
        return redirect()->route('communites.index')->with(['success'=>'تم اضافة المجتمع بنجاح']);
    }
}
