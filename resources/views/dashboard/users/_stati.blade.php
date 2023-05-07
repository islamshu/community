
<div class="form-body">
    
    <div class="row">
        <div class="col-md-6 mt-2">
            <label>رابط الافلييت  </label>
            {{ dd($user) }}
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
            $register_user = User::where('referrer_id',$user)->count();
            $paid_user = User::where('referrer_id',$user)->where('is_paid',1)->count();
            @endphp
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


