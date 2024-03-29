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
use App\Mail\Invoice;
use App\Mail\MessageEmail;
use App\Models\BankInfo;
use App\Models\BlalnceRequest;
use App\Models\Currency;
use App\Models\DiscountCode;
use App\Models\Domians;
use App\Models\Invoice as ModelsInvoice;
use App\Models\MailMessage;
use App\Models\Message;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\DB;
use Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use PDF;

class UserController extends Controller
{
    public function show_message_from_user($id1,$id2)
    {
        $messages =Message::where('sender_id',$id1)->Where('receiver_id',$id2)->orwhere('sender_id',$id2)->where('receiver_id',$id1)->orderby('id','desc')->get();
        $conversations =Message::where('sender_id',$id2)->orWhere('receiver_id',$id2)->get();

        $users = $conversations->map(function($conversation) use($id2){
            if($conversation->sender_id == $id2) {
                return $conversation->receiver;
            }
            return $conversation->sender;
            })->unique();
                return view('dashboard.users.chat')
                ->with('users',$users)
                ->with('user',$id2)
                ->with('messages',$messages)
                ->with('sender',User::find($id1))
                ->with('resever',User::find($id2));
    }

    public function verfty_email($id){
        $encid = Crypt::decrypt($id);
        $user = User::find($encid);
        $user->email_verified_at = now();
        $user->save();
        Mail::to($user->email)->send(new Confirm_email());
        return Redirect::to('https://community.arabicreators.com/profile');
     }
    public function index()
    {
        $users = User::where('type', 'user')->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'جميع الأعضاء');
    }
    public function paid_user()
    {
        $users = User::where('type', 'user')->where('is_paid', 1)->where('is_free',0)->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'العضويات المدفوعة');
    }
    public function un_paid_user()
    {
        $users = User::where('type', 'user')->where('is_paid', 0)->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'العضويات المجانية ');
    }
    public function free_users()
    {
        $users = User::where('type', 'user')->where('is_paid', 1)->where('is_free',1)->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'مشترك مجاني');
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
            $messagecode->message = ': للاسف تم رفضك كمسوق في العمولة للاسباب التالية '.$request->message;
            $messagecode->save();
            $mess=[
                'title'=>'تم رفض قبولك التسويق بالعمولة',
                'message' =>  'للاسف تم رفضك كمسوق في العمولة للاسباب التالية '  .'</br>'.$request->message,
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
    public function show(Request $request,$id)
    {
        $from = $request->form;
        $to = $request->to;
        $user = User::find($id);
        $subs = ModelsInvoice::where('user_id',$id)->orderby('id','desc')->get();
        // $vids = 
        $domains = Domians::orderby('id','desc')->get();
        $vids = UserVideo::where('email',$user->email)->orderby('id','desc')->get();
        if($from != null && $to != null ){
            $users = User::where('referrer_id',$id)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->whereBetween('created_at', [$from, $to])->get();
            $userspaid = User::where('referrer_id',$id)->where('is_paid',1)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->whereBetween('created_at', [$from, $to])->get();
        }else{
            $users = User::where('referrer_id',$id)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->get();
            $userspaid = User::where('referrer_id',$id)->where('is_paid',1)->selectRaw('MONTH(created_at) AS month, COUNT(*) AS total')
            ->groupBy('month')
            ->get();
        }
        
    // Formatting the data for the column chart
    $chartData = [
        'labels' => [],
        'datasets' => [],
    ];
    $chartData2 = [
        'labels' => [],
        'datasets' => [],
    ];
    


    // Populate the labels array
    foreach ($users as $user) {
        $monthName = Carbon::createFromFormat('!m', $user->month)->format('F');
        $chartData['labels'][] = $monthName;
        $chartData2['labels'][] = $monthName;

    }
    foreach ($userspaid as $user) {
        $monthName = Carbon::createFromFormat('!m', $user->month)->format('F');
        $chartData['labels'][] = $monthName;
        $chartData2['labels'][] = $monthName;
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
    }
    $dataset3 = [
        'label' => 'اجمالي الرصيد من التسجيل',
        'data' =>@$dataset1['data'][0] != null ? [@$dataset1['data'][0] * get_general_value('register_member')] : [0] ,
        'backgroundColor' => 'rgba(141, 99, 111, 0.5)',
        'borderColor' => 'rgba(141, 99, 111, 1)',
        'borderWidth' => 1,
    ];
    $dataset4 = [
        'label' => 'اجمالي الرصيد من المشتركين',
        'data' => @$dataset2['data'][0] != null ? [$dataset2['data'][0] * get_general_value('register_member_paid')]  : [0],
        'backgroundColor' => 'rgba(200, 99, 111, 0.5)',
        'borderColor' => 'rgba(200, 99, 111, 1)',
        'borderWidth' => 1,
    ];

    // Add the datasets to the chart data
    $chartData['datasets'][] = $dataset1;
    $chartData['datasets'][] = $dataset2;
    $chartData2['datasets'][] = $dataset3 ;
    $chartData2['datasets'][] = $dataset4 ;
    $conversations =Message::where('sender_id',$id)->orWhere('receiver_id',$id)->get();
    
    $users = $conversations->map(function($conversation) use($id){
    if($conversation->sender_id == $id) {
        return $conversation->receiver;
    }

    return $conversation->sender;
    })->unique();
    

    // dd($chartData);

        return view('dashboard.users.show')->with('users',$users)->with('request',$request)->with('chartData',$chartData)->with('chartData2',$chartData2)->with('domains',$domains)->with('user', User::find($id))->with('subs',$subs)->with('vids',$vids);
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
        dd($request->general);
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
        $currency = Currency::where('symbol','USD')->first();

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
        $currency = Currency::where('symbol','USD')->first();
        
        $packege = Package::find($request->packege_id);
        $price = $packege->price;
        if($request->discount_amount != null && $request->discount_amount != 0){
            $discount_price = $price * ($request->discount_amount/ 100);
            $pricee = $price -$discount_price; 
            $sub->is_packge_discount = 1;
            $sub->packge_discount =   $request->packge_discount ;
            $sub->price_after_packge_discount = $pricee;
            $sub->discount_amount = $request->discount_amount;
            $pricee = $sub->price_after_packge_discount ;
        }else{
            $pricee = $packege->price;
            $sub->price_after_all_discount = $pricee;
        }
        if($request->promocode != null){
            $code = DiscountCode::where('code',$request->promocode)->first();
            $now = today();
            if($code){
                if ($code->start_at <= $now && $code->end_at >= $now) {
                    $type = $code->discount_type;
                    $sub->discount_code = $request->promocode;
                    if($type == 'fixed'){
                       
                       
                        if($request->discount_amount != null && $request->discount_amount != 0){
                            $price_code_descount = $pricee - $code->discount_value; 
                            $sub->price_after_all_discount = $price_code_descount; 
                            $price_code_descount = $packege->price - $code->discount_value; 
                            $sub->price_after_discount = $price_code_descount;

                        }else{
                            $price_code_descount = $packege->price - $code->discount_value; 
                            $sub->price_after_discount = $price_code_descount;
                            $sub->price_after_all_discount = $price_code_descount; 
                        }
                        }else{
                            if($request->discount_amount != null && $request->discount_amount != 0){
                                $pricemm = $pricee;
                                $discount_price = $pricemm * ($code->discount_value/ 100);
                                $price_code_descount = $pricemm -$discount_price; 
                                $sub->price_after_discount = $price_code_descount;
                                $sub->price_after_all_discount = $price_code_descount; 

                             }else{
                                $pricemm = $packege->price;
                                $discount_price = $pricemm * ($code->discount_value/ 100);
                                $price_code_descount = $pricemm -$discount_price; 
                                $sub->price_after_discount = $price_code_descount;
                                $sub->price_after_all_discount = $price_code_descount; 
                            }
                       
                    }
                } else {
                    return redirect()->back()->with(['success'=>'تم انتهاء صلاحية كود الخصم']);
                }
                
            }else{
                return redirect()->back()->with(['success'=>'كود الخصم غير موجود']);
            }
        }else{
            $sub->price_after_all_discount = $pricee;
        }
        

        // $proo = $packege->price - $sub->price_after_packge_discount -  $sub->price_after_discount;
        $sub->user_id = $user->id;
        $sub->amount = $pricee;
        $sub->main_price= $packege->price;
        $sub->package_id = $packege->id;
        $sub->start_at = Carbon::now()->format('Y-m-d');
        $sub->end_at = Carbon::now()->addMonths($packege->period)->format('Y-m-d');
        $sub->status = 0;
        $sub->code = date('Ymd-His').rand(10,99);
        $sub->peroud = $packege->period;
        $sub->payment_method = 'From Admin';
        $sub->payment_info = json_encode($request->all());
        $sub->currency_symble = $currency->symbol;
        $sub->currency_amount = $currency->value_in_dollars;
        $sub->price_with_currency = $sub->price_after_all_discount * $currency->value_in_dollars;
        
        $sub->currency_symble = $currency->symbol;
        $sub->currency_amount = $currency->value_in_dollars;
        $sub->price_with_currency = $sub->price_after_all_discount * $currency->value_in_dollars;
        
        $sub->save();
        return redirect()->route('users.index')->with(['success' => 'تم اضافة العضو']);
    }
    public function viewPdf($code)
    {
        $sub = Subscription::where('code',$code)->first();
        $is_finish = $sub->user->is_finish == 1 ? 1 : 0;
        return view('pdf.order')->with('sub',$sub)->with('is_finish',$is_finish);
    }
    public function invoideviewPdf($code)
    {
        $sub = ModelsInvoice::where('code',$code)->first();
        return view('pdf.invoice')->with('sub',$sub);
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
        $user->updater_id = auth('admin')->id();
        if($request->is_paid == 1){
            if ($user->referrer_id != null) {
                $refref = User::find($user->referrer_id);
                // if($reffer->is_able_affilete == 1){
                    if ($refref->is_paid) {
                        $refref->total_balance += get_general_value('register_member_paid');
                        $refref->total_withdrowable += get_general_value('register_member_paid');
                        $refref->save();
                    // }
                }
                
            }
        }
        $user->domains = json_encode($request->domains);
        // $user->admin_id = auth('admin')->id(); 
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
        $packege = Package::find($request->packege_id);
        $price = $packege->price;
        if($request->discount_amount != null && $request->discount_amount != 0){
            $discount_price = $price * ($request->discount_amount/ 100);
            $pricee = $price -$discount_price; 
            $sub->is_packge_discount = 1;
            $sub->packge_discount =   $request->packge_discount ;
            $sub->price_after_packge_discount = $pricee;
            $sub->discount_amount = $request->discount_amount;
            $pricee = $sub->price_after_packge_discount ;
        }else{
            $pricee = $packege->price;
            $sub->price_after_all_discount = $pricee;
        }
        if($request->promocode != null){
            $code = DiscountCode::where('code',$request->promocode)->first();
            $now = today();
            if($code){
                if ($code->start_at <= $now && $code->end_at >= $now) {
                    $type = $code->discount_type;
                    $sub->discount_code = $request->promocode;
                    if($type == 'fixed'){
                       
                       
                        if($request->discount_amount != null && $request->discount_amount != 0){
                            $price_code_descount = $pricee - $code->discount_value; 
                            $sub->price_after_all_discount = $price_code_descount; 
                            $price_code_descount = $packege->price - $code->discount_value; 
                            $sub->price_after_discount = $price_code_descount;

                        }else{
                            $price_code_descount = $packege->price - $code->discount_value; 
                            $sub->price_after_discount = $price_code_descount;
                            $sub->price_after_all_discount = $price_code_descount; 
                        }
                        }else{
                            if($request->discount_amount != null && $request->discount_amount != 0){
                                $pricemm = $pricee;
                                $discount_price = $pricemm * ($code->discount_value/ 100);
                                $price_code_descount = $pricemm -$discount_price; 
                                $sub->price_after_discount = $price_code_descount;
                                $sub->price_after_all_discount = $price_code_descount; 

                             }else{
                                $pricemm = $packege->price;
                                $discount_price = $pricemm * ($code->discount_value/ 100);
                                $price_code_descount = $pricemm -$discount_price; 
                                $sub->price_after_discount = $price_code_descount;
                                $sub->price_after_all_discount = $price_code_descount; 
                            }
                       
                    }
                } else {
                    return redirect()->back()->with(['success'=>'تم انتهاء صلاحية كود الخصم']);
                }
                
            }else{
                return redirect()->back()->with(['success'=>'كود الخصم غير موجود']);
            }
        }else{
            $sub->price_after_all_discount = $pricee;
        }
        

        // $proo = $packege->price - $sub->price_after_packge_discount -  $sub->price_after_discount;
        $sub->user_id = $user->id;
        $sub->amount = $pricee;
        $sub->main_price= $packege->price;
        $sub->package_id = $packege->id;
        $sub->start_at = Carbon::now()->format('Y-m-d');
        $sub->end_at = Carbon::now()->addMonths($packege->period)->format('Y-m-d');
        $sub->status = 0;
        $sub->code = date('Ymd-His').rand(10,99);
        $sub->peroud = $packege->period;
        $sub->payment_method = 'From Admin';
        $sub->payment_info = json_encode($request->all());
        $sub->save();
        }
     
        return redirect()->back()->with(['success' => 'تم تعديل العضو']);
    }
    public function destroy($id)
    {

        $user = User::find($id);
        $banks = BankInfo::where('user_id',$id)->delete();
        $user->invoices()->delete();
        $user->mailMessages()->delete();
        $user->soical_new()->delete();
        Message::where('sender_id',$user->id)->orwhere('receiver_id',$user->id)->delete();
        $user->delete();
        return redirect()->route('users.index')->with(['success' => 'تم حذف العضو']);
    }
}
