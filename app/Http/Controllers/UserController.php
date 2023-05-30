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
use App\Mail\Confirm_email;
use App\Mail\MessageEmail;
use App\Models\BankInfo;
use App\Models\BlalnceRequest;
use App\Models\Domians;
use App\Models\MailMessage;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\DB;
use Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use PDF;

class UserController extends Controller
{

    public function verfty_email($id){
        $encid = Crypt::decrypt($id);
        $user = User::find($encid);
        $user->email_verified_at = now();
        $user->save();
        Mail::to($user->email)->send(new Confirm_email());
        return Redirect::to('https://community.arabicreators.com/');
     }
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
        $domains = Domians::orderby('id','desc')->get();
        return view('dashboard.users.create')->with('domains',$domains);
    }
    public function show_bank_info($id){
        $bank = BankInfo::find($id);
        return view('dashboard.users.bank_info')->with('bank',$bank);
    }
    public function change_status_payment(Request $request,$id){
        $bank = BlalnceRequest::find($id);
        $user = User::find($bank->user_id);
        $bank->error_message = $request->message;
        // $user = $bank->user_id;
        // dd($user);
        if($request->status == 1){
            // $user->total_balance += $bank->amount;
            $user->pending_balance -= $bank->amount;
            // $user->total_withdrowable -= $bank->amount;
            $user->total_withdrow += $bank->amount;
            $user->save();
            $bank->status = 1;
            $bank->save();
          
        }elseif($request->status == 0){
            // $user->total_balance = $bank->amount;
            $user->pending_balance = $user->pending_balance- $bank->amount;
            $user->total_withdrowable += $bank->amount;
            $user->save();
            $bank->status = 0;
            $bank->save();
        }
        $bank->save();
        if($request->status == 1){
            $date_send = [
                'id' => $user->id,
                'name' => $user->name,
                'url' => '',
                'title' => 'تم  قبول عملية التحويل  ',
                'time' => $user->updated_at
            ];
            $messagecode =new  MailMessage();
            $messagecode->user_id = $user->id;
            $messagecode->title = 'تم  قبول عملية التحويل ';
            $messagecode->message = 'تم  قبول عملية التحويل بقيمة  ' . $bank->amount;
            $messagecode->save();
            $mess=[
                'title'=>'تم قبول عملية التحويل  ',
                'message' => 'تم  قبول عملية التحويل بقيمة '.'$'. $bank->amount,
            ];
            Mail::to($user->email)->send(new MessageEmail($mess));
        }elseif($request->status == 0){
            $date_send = [
                'id' => $user->id,
                'name' => $user->name,
                'url' => '',
                'title' => 'تم  رفض عملية التحويل  ',
                'time' => $user->updated_at
            ];
            $messagecode =new  MailMessage();
            $messagecode->user_id = $user->id;
            $messagecode->title = 'تم  رفض عملية التحويل ';
            $messagecode->message = $request->message;
            $messagecode->save();
            $mess=[
                'title'=>'تم رفض عملية التحويل',
                'message' => $request->message,
            ];
            Mail::to($user->email)->send(new MessageEmail($mess));

        }
        
        $user->notify(new GeneralNotification($date_send));
        return redirect()->back()->with(['success'=>'تم الحفظ بنجاح']);
    }
    public function change_status(Request $request,$id){
        $bank = BankInfo::find($id);
        $bank->status = $request->status;
        $bank->error_message = $request->message;
        $bank->save();
        $user = User::find($bank->user->id);
        $user->is_able_affilete = $request->status;
        $user->save();
        // 'islam'
        if($request->status == 1){
            $date_send = [
                'id' => $user->id,
                'name' => $user->name,
                'url' => 'https://community.arabicreators.com/bank_info',
                'title' => 'تم  قبولك بالتسويق بالعمولة',
                'time' => $user->updated_at
            ];
            $messagecode =new  MailMessage();
            $messagecode->user_id = $user->id;
            $messagecode->title = 'تم  قبولك لدينا كمسوق بالعمولة  ';
            $messagecode->message = 'تهانينا لقد تم قبولك لدينا كمسوق بالعمولة';
            $messagecode->save();
            $mess=[
                'title'=>'تم  قبولك لدينا كمسوق بالعمولة  ',
                'message' =>  'تهانينا لقد تم قبولك لدينا كمسوق بالعمولة',
            ];
            Mail::to($user->email)->send(new MessageEmail($mess));
        }elseif($request->status == 0){
            $date_send = [
                'id' => $user->id,
                'name' => $user->name,
                'url' => 'https://community.arabicreators.com/bank_info',
                'title' => 'تم رفض قبولك التسويق بالعمولة',
                'time' => $user->updated_at
            ];
            $messagecode =new  MailMessage();
            $messagecode->user_id = $user->id;
            $messagecode->title = 'تم رفض قبولك التسويق بالعمولة';
            $messagecode->message = 'للاسف تم رفضك كمسوق في العمولة للاسباب التالية ' .$request->message;
            $messagecode->save();
            $mess=[
                'title'=>'تم رفض قبولك التسويق بالعمولة',
                'message' =>  'للاسف تم رفضك كمسوق في العمولة للاسباب التالية ' .$request->message,
            ];
            Mail::to($user->email)->send(new MessageEmail($mess));
        }
        
        $user->notify(new GeneralNotification($date_send));
        return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
    }
    public function show_noti($id){
        $not = DB::table('notifications')->where('id',$id)->first();
        $url_data = $not->data;
        return redirect(json_decode($url_data)->url);
    }
    public function show($id)
    {
        $user = User::find($id);
        $subs = Subscription::where('user_id',$id)->where('status',1)->orderby('id','desc')->get();
        // $vids = 
        $domains = Domians::orderby('id','desc')->get();
        $vids = UserVideo::where('email',$user->email)->orderby('id','desc')->get();
        
        $users = User::where('referrer_id',$id)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
        ->groupBy('month')
        ->get();
        $userspaid = User::where('referrer_id',$id)->where('is_paid',1)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
        ->groupBy('month')
        ->get();
    // Formatting the data for the column chart
    $chartData = [
        'labels' => [],
        'datasets' => [],
    ];


    // Populate the labels array
    foreach ($users as $user) {
        $monthName = Carbon::createFromFormat('!m', $user->month)->format('F');
        $chartData['labels'][] = $monthName;
    }
    foreach ($userspaid as $user) {
        $monthName = Carbon::createFromFormat('!m', $user->month)->format('F');
        $chartData['labels'][] = $monthName;
    }

    // Define dataset 1
    $dataset1 = [
        'label' => 'المسجلين',
        'data' => [],
        'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
        'borderColor' => 'rgba(54, 162, 235, 1)',
        'borderWidth' => 1,
    ];

    // Define dataset 2
    $dataset2 = [
        'label' => 'الدافعين',
        'data' => [],
        'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
        'borderColor' => 'rgba(255, 99, 132, 1)',
        'borderWidth' => 1,
    ];
    $dataset3 = [
        'label' => 'اجمالي الرصيد من التسجيل',
        'data' => [],
        'backgroundColor' => 'rgba(255, 99, 111, 0.5)',
        'borderColor' => 'rgba(255, 99, 111, 1)',
        'borderWidth' => 1,
    ];

    // Populate the data arrays for each dataset
    foreach ($users as $user) {
        $dataset1['data'][] = $user->total;
        // $dataset2['data'][] =  $user->where('is_paid',1)->count();// Add your logic here to fetch data for the second dataset
    }
    foreach ($userspaid as $user) {
        $dataset2['data'][] = $user->total;
        // $dataset2['data'][] =  $user->where('is_paid',1)->count();// Add your logic here to fetch data for the second dataset
    }
    

    // Add the datasets to the chart data
    $chartData['datasets'][] = $dataset1;
    $chartData['datasets'][] = $dataset2;
    dd($dataset1['data'][0]);
    // $chartData['datasets'][] =  * 5 ;

    // dd($chartData);

        return view('dashboard.users.show')->with('chartData',$chartData)->with('domains',$domains)->with('user', User::find($id))->with('subs',$subs)->with('vids',$vids);
    }
    public function edit($id)
    {
        $domains = Domians::orderby('id','desc')->get();
        return view('dashboard.users.edit')->with('user', User::find($id))->with('domains',$domains);
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
            'have_website' => 'required',
            'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        if($request->phone != null){
            $request->validate([
            'phone' => 'unique:users,phone',
        ]);

        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->phone = $request->phone;
        $array=[];
        
        // $user->domains = json_encode($request->domains);
        $user->check_register = 1;
        $user->have_website = $request->have_website;
        $user->site_url = $request->site_url;
        $user->type = 'user';
        $user->image = $request->image->store('users');
        $user->video = 'user_video/defult.mp4';
        $user->packege_id = $request->packege_id;
        $user->is_paid = 1;
        $user->ref_code = $user->name . '_' . now()->timestamp;
        $user->admin_id = auth('admin')->id(); 
        $user->save();
        $packege = Package::find($request->packege_id);
        $sub = new Subscription();
        $sub->user_id = $user->id;
        $sub->amount = $packege->price;
        $sub->package_id = $packege->id;
        $sub->start_at = Carbon::parse($request->start_date)->format('Y-m-d');
        $sub->end_at = Carbon::parse($request->start_date)->addMonths($packege->period)->format('Y-m-d');
        $sub->status = 1;
        $sub->peroud = $packege->period;
        $sub->admin_id = auth('admin')->id(); 
        $sub->payment_method = 'From Admin';
        $sub->payment_info = json_encode($request->all());
        $sub->save();
        return redirect()->route('users.index')->with(['success' => 'تم اضافة العضو']);
    }
    public function viewPdf($code)
    {
        $sub = Subscription::where('code',$code)->first();
        $is_finish = $sub->user->is_finish == 1 ? 1 : 0;
        return view('pdf.order')->with('sub',$sub)->with('is_finish',$is_finish);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $paid = $user->is_paid;
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            // 'password' => 'required',
            'have_website' => 'required',
            'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        if($request->phone != null){
            $request->validate([
                'phone' => 'unique:users,phone,' . $user->id,
            ]);

        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password =  Hash::make($request->password);
        }
        $user->phone = $request->phone;
        $user->have_website = $request->have_website;
        $user->site_url = $request->site_url;
        $user->is_paid = $request->is_paid;
        $user->domains = json_encode($request->domains);
        $user->admin_id = auth('admin')->id(); 
        $user->type = 'user';
        if ($request->image != null) {
            $user->image = $request->image->store('users');
        }
        $user->packege_id = $request->packege_id;
        if($user->ref_code == null){
            $user->ref_code = $user->name . '_' . now()->timestamp;
        }

        $user->save();
        $last_sub = Subscription::where('user_id',$user->id)->first();
        $packege = Package::find($request->packege_id);

        if($request->is_paid == 1 && $paid == 1){

        if($request->start_date != $last_sub->start_at){
            $last_sub->start_at = $request->start_date ;
            $last_sub->start_at = Carbon::parse($request->start_date)->format('Y-m-d');
            $last_sub->end_at = Carbon::parse($request->start_date)->addMonths($packege->period)->format('Y-m-d');
            $last_sub->save();
        }
        }

        if($request->is_paid == 1 && $paid == 0){
            $last_sub = Subscription::where('user_id',$user->id)->first();
            $sub = new Subscription();
            $sub->user_id = $user->id;
            $sub->amount = $packege->price;
            $sub->package_id = $packege->id;
            $sub->start_at = Carbon::parse($request->start_date)->format('Y-m-d');
            $sub->end_at = Carbon::parse($request->start_date)->addMonths($packege->period)->format('Y-m-d');
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
