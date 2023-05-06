<?php

namespace App\Http\Controllers;

use App\Models\GeneralInfo;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserVideo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Hash;
use App\GoogleMeetService;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('type', 'user')->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'جميع المستخدمين');
    }
    public function paid_user()
    {
        $users = User::where('type', 'user')->where('is_paid', 1)->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'جميع المستخدمين المشتركين');
    }
    public function un_paid_user()
    {
        $users = User::where('type', 'user')->where('is_paid', 0)->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'جميع المستخدمين الغير مشتركين');
    }
    public function create()
    {
        return view('dashboard.users.create');
    }
    public function show($id)
    {
        $user = User::find($id);
        $subs = Subscription::where('user_id',$id)->where('status',1)->orderby('id','desc')->get();
        // $vids = 
        $vids = UserVideo::where('email',$user->email)->orderby('id','desc')->get();
        return view('dashboard.users.show')->with('user', User::find($id))->with('subs',$subs)->with('vids',$vids);
    }
    public function edit($id)
    {
        return view('dashboard.users.edit')->with('user', User::find($id));
    }
    public function user_update_status(Request $request)
    {
        $user = User::find($request->user_id);
        $user->check_register = $request->check_register;
        $user->save();
    }
    public function add_general(Request $request)
    {
        if ($request->hasFile('general_file')) {
            foreach ($request->file('general_file') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value->store('general'));
            }
        }
        if ($request->has('general')) {

            foreach ($request->input('general') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value);
            }
        }

        return redirect()->back()->with(['success' => 'تم تعديل البيانات بنجاح']);
    }
    public function add_general_meeting(Request $request)
    {
        
        if ($request->has('general')) {

            foreach ($request->input('general') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value);
            }
        }
        $summary = 'المجتمع العربي ';
        $description =  'المجتمع العربي ';


        $startTime =  Carbon::parse(get_general_value('meeting_date'));
        
        $endTime = Carbon::parse(get_general_value('meeting_date'))->addMinute(get_general_value('meeting_time'));
        GeneralInfo::setValue('meeting_end', $endTime);

        $emails =['islamshu12@gmail.com'];
        
        
        $googleAPI = new GoogleMeetService();
        $event = $googleAPI->createMeet($summary, $description, $startTime, $endTime,$emails);
        GeneralInfo::setValue('meeting_url', $event->hangoutLink);
        GeneralInfo::setValue('finish_time', $event->end->dateTime);


        return redirect()->back()->with(['success' => 'تم تعديل البيانات بنجاح']);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'phone' => 'required|unique:users,phone',
            'have_website' => 'required',
            'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->phone = $request->phone;
        $user->domains = $request->domains;
        $user->have_website = $request->have_website;
        $user->site_url = $request->site_url;
        $user->type = 'user';
        $user->image = $request->image->store('users');
        $user->video = 'user_video/defult.mp4';
        $user->packege_id = $request->packege_id;
        $user->is_paid = 1;
        $user->admin_id = auth('admin')->id(); 
        $user->save();
        $packege = Package::find($request->packege_id);
        $sub = new Subscription();
        $sub->user_id = $user->id;
        $sub->amount = $packege->price;
        $sub->package_id = $packege->id;
        $sub->start_at = Carbon::now()->format('Y-m-d');
        $sub->end_at = Carbon::now()->addMonths($packege->period)->format('Y-m-d');
        $sub->status = 1;
        $sub->peroud = $packege->period;
        $sub->admin_id = auth('admin')->id(); 
        $sub->payment_method = 'From Admin';
        $sub->payment_info = json_encode($request->all());
        $sub->save();
        return redirect()->route('users.index')->with(['success' => 'تم اضافة العضو']);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $paid = $user->is_paid;
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            // 'password' => 'required',
            'phone' => 'required|unique:users,phone,' . $user->id,
            'have_website' => 'required',
            'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password =  Hash::make($request->password);
        }
        $user->phone = $request->phone;
        $user->have_website = $request->have_website;
        $user->site_url = $request->site_url;
        $user->is_paid = $request->is_paid;
        $user->domains = $request->domains;
        $user->admin_id = auth('admin')->id(); 
        $user->type = 'user';
        if ($request->image != null) {
            $user->image = $request->image->store('users');
        }
        $user->packege_id = $request->packege_id;
        $user->save();
        if($request->is_paid == 1 && $paid == 0){
            $packege = Package::find($request->packege_id);
            $sub = new Subscription();
            $sub->user_id = $user->id;
            $sub->amount = $packege->price;
            $sub->package_id = $packege->id;
            $sub->start_at = Carbon::now()->format('Y-m-d');
            $sub->end_at = Carbon::now()->addMonths($packege->period)->format('Y-m-d');
            $sub->status = 1;
            $sub->peroud = $packege->period;
            $sub->payment_method = 'From Admin';
            $sub->admin_id = auth('admin')->id(); 
            $sub->payment_info = json_encode($request->all());
            $sub->save();
        }
     
        return redirect()->back()->with(['success' => 'تم تعديل العضو']);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with(['success' => 'تم حذف العضو']);
    }
}
