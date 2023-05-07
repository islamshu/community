@php
            if($user->ref_code == null){
            $ref =  'لا يوجد';
            }else{
                $ref= route('my_affilite',$user->ref_code);
            }
            $aff = App\Models\AffiliteUser::where('user_id',$user->id)->first();
            if($aff){
                $number_show = $aff->show;
            }else{
                $number_show = 0;
            }
            $register_user = App\Models\User::where('referrer_id',$user->id)->count();
            $paid_user = App\Models\User::where('referrer_id',$user->id)->where('is_paid',1)->count();
@endphp
<div class="form-body">
    
    <div class="row">
        <div class="col-md-6 mt-2">
            <label>اجمالي الرصيد</label>
            
            <input  readonly type="string" value="{{ $user->total_balance}}" name="name" class="form-control" required >
        </div>
        <div class="col-md-6 mt-2">
            <label>الرصيد القابل للسحب</label>
            
            <input  readonly type="string" value="{{ $user->total_withdrowable}}" name="name" class="form-control" required >
        </div>
        <div class="col-md-6 mt-2">
            <label>رابط الافلييت  </label>
            
            <input  readonly type="string" value="{{ $ref}}" name="name" class="form-control" required >
        </div>
        <div class="col-md-6 mt-2">
            <label>عدد المشاهدات    </label>
            <input  readonly type="text" value="{{ $number_show }}" name="email" class="form-control" required >
        </div>
        <br>
        <div class="col-md-6 mt-2">
            <label> عدد الاعضاء المسجلين من خلاله   </label>
            <input  readonly type="text" name="phone" value="{{ $register_user }}" class="form-control" required >
        </div>
        <br>
        <div class="col-md-6 mt-2">
            <label> عدد الاعضاء الدافعين من خلاله   </label>
            <input  readonly type="text" name="phone" value="{{ $paid_user }}" class="form-control" required >
        </div>
        <br>
    
    </div>
    

</div>


