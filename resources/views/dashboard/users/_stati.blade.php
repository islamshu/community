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
        <div class="col-xl-4 col-lg-12 col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">الاحصائيات</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <canvas id="chart4" width="200" height="200"></canvas>
                </div>
              </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">احصائيات الافلييت</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <canvas id="chart3" width="200" height="200"></canvas>
                </div>
              </div>
            </div>
        </div>
    </div>
        <div class="row">
          <div class="col-xl-6 col-lg-12 col-md-12">
              <h1 class="mt-4 mb-4 text-center">Column Chart Example</h1>
              <div class="card">
                  <div class="card-body">
                      <canvas id="columnChart"></canvas>
                  </div>
              </div>
          </div>
      
        <div class="col-xl-6 col-lg-12 col-md-12">
            <h1 class="mt-4 mb-4 text-center">Column Chart Example</h1>
            <div class="card">
                <div class="card-body">
                  <canvas id="columnChart2"></canvas>
                </div>
            </div>
        </div>
    </div>


    </div>
    <div class="row">
        
        <div class="col-md-6 mt-2">
            <label>اجمالي الرصيد</label>
            
            <input  readonly type="string" value="${{ $user->total_balance}}" name="name" class="form-control" required >
        </div>
        <div class="col-md-6 mt-2">
            <label>الرصيد القابل للسحب</label>
            
            <input  readonly type="string" value="${{ $user->total_withdrowable}}" name="name" class="form-control" required >
        </div>
        <div class="col-md-6 mt-2">
            <label>رابط الافلييت  </label>
            
            <input  readonly type="string" value="{{ $ref}}" name="name" class="form-control" required >
        </div>
        <div class="col-md-6 mt-2">
            <label>اجمالي المشاهدات    </label>
            <input  readonly type="text" value="{{ $number_show }}" name="email" class="form-control" required >
        </div>
        <br>
        <div class="col-md-6 mt-2">
            <label>مجموع عمليات تسجيل الدخول   </label>
            <input  readonly type="text" name="phone" value="{{ $register_user }}" class="form-control" required >
        </div>
        <br>
        <div class="col-md-6 mt-2">
            <label> مجموع المشتركين   </label>
            <input  readonly type="text" name="phone" value="{{ $paid_user }}" class="form-control" required >
        </div>
        <br>
    
    </div>
    

</div>


