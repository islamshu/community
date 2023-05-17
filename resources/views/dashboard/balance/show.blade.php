@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> البيانات البنكية الخاصة ب
                                {{ $balace->user->name }} </h4>
                                <a href="{{ route('users.show',$balace->user->id) }}" class="btn btn-info"><i class="fa fa-eye"></i>مشاهدة ملف المستخدم</a>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @include('dashboard.parts._error')
                                @include('dashboard.parts._success')

                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="col-12 col-md-12">
                                            <div class="card">
                                              <div class="card-header">
                                                <h4 class="card-title text-center"> الارصدة </h4>
                                              </div>
                                              <div class="card-content collapse show">
                                                <div class="card-body pt-0">
                                                  <div class="row">
                                                    <div class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">
                                                      <h4 class="font-large-2 text-bold-400">{{ $balace->user->total_balance }}</h4>
                                                      <p class="blue-grey lighten-2 mb-0">  الرصيد الاجمالي</p>
                                                    </div>
                                                    <div class="col-md-3 col-12 text-center">
                                                      <h4 class="font-large-2 text-bold-400">{{ $balace->user->total_withdrowable }}</h4>
                                                      <p class="blue-grey lighten-2 mb-0">  الرصيد القابل للسحب</p>
                                                    </div>
                                                    <div class="col-md-3 col-12 text-center">
                                                        <h4 class="font-large-2 text-bold-400">{{ $balace->user->pending_balance }}</h4>
                                                        <p class="blue-grey lighten-2 mb-0"> الرصيد المعلق</p>
                                                      </div>
                                                      <div class="col-md-3 col-12 text-center">
                                                        <h4 class="font-large-2 text-bold-400">{{ $balace->user->total_withdrow }}</h4>
                                                        <p class="blue-grey lighten-2 mb-0"> الرصيد المسحوب</p>
                                                      </div>
                                                      
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        <div class="row">
                                            
                                            @php
                                                $array_type = json_decode($balace->payment_detiles);
                                            @endphp
                                            
                                            <div class="col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="username">طريقة استلام :</label>
                                                    <input type="text" value="{{ $balace->paid_method }}" class="form-control" disabled name="" id="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="username">القيمة  :</label>
                                                    <input type="text" value="{{ $balace->amount }}" class="form-control" disabled name="" id="">
                                                </div>
                                            </div>
                                                <div class="col-md-6 mt-2">
                                                    @if($balace->status  == 2)
                                                    <form action="{{ route('change_status_payment',$balace->id) }}" method="post">
                                                        @csrf
                                                        <div class="col-md-6">
                                                            <label for="" class="">حالة الطلب</label>
                                                            <select required id="select_change"
                                                                class="form-control {{ $balace->status }}" name="status">
                                                                <option value="1" @if($balace->status == 1) selected @endif>مقبول </option>
                                                                <option value="2" @if($balace->status == 2) selected @endif>جاري المتابعة</option>
                                                                <option value="0" @if($balace->status == 0) selected @endif>رفض</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mt-10" style="display: none" id="btn_submit">
                                                            <input type="submit"  class="btn btn-info" value="تأكيد">
                                                        </div>
        
                                                    </form>
                                                    @else
                                                    <button class="btn btn-{{ get_status_button($balace->status) }}">{{ get_status($balace->status) }}</button>
                                                    @endif
        
                                                </div>
                                        </div>
                                        <br> <br>
                                        @if($balace->paid_method == 'paypal')
                                        <fieldset style="width:80%">
                                            <legend>بيانات الباي بال:</legend>
                                            <div class="col-md-6 mt-2">
                                                <label>البريد الاكتروني </label>
                                                <input disabled type="email" value="{{ get_withdrow_detiles($array_type,'paypal_email')  }}"
                                                    name="email" class="form-control" required>
                                            </div>
                                        </fieldset>
                                        @endif
                                        <br>
                                        @if($balace->paid_method == 'westron')
                                        <fieldset style="width:80%">
                                            <legend>بيانات الويسترن يونيون :</legend>
                                            <div class="col-md-6 mt-2">
                                                <label>الاسم كامل </label>
                                                <input disabled type="email" value="{{get_withdrow_detiles($array_type,'full_name')  }}" name="email"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>رقم الهوية </label>
                                                <input disabled type="email" value="{{get_withdrow_detiles($array_type,'personID') }}" name="email"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>صورة الهوية </label>
                                                <div class="form-group">
                                                    <img src="{{ get_withdrow_detiles($array_type,'Idimage')}}" style="width: 100px"
                                                        class="img-thumbnail image-preview" alt="">
                                                        <a target="_blank" href="{{ get_withdrow_detiles($array_type,'Idimage')}}">مشاهدة</a>
                                                    </div>
                                            </div>
                                        </fieldset>
                                        @endif
                                        <br>
                                        @if($balace->paid_method == 'bank')

                                        <fieldset style="width:80%">
                                            <legend>بيانات البنك :</legend>
                                            <div class="col-md-6 mt-2">
                                                <label>اسم البنك </label>
                                                <input disabled type="email" value="{{ get_withdrow_detiles($array_type,'bank_name') }}" name="email"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>رقم الايبان </label>
                                                <input disabled type="email" value="{{ get_withdrow_detiles($array_type,'iban_number') }}"
                                                    name="email" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>اسم صاحب الحساب </label>
                                                <input disabled type="email" value="{{ get_withdrow_detiles($array_type,'owner_name') }}"
                                                    name="email" class="form-control" required>

                                            </div>
                                        </fieldset>
                                        @endif

                                    </div>
                                </div>





                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </div>
    </section>

    </div>
@endsection
@section('script')
<script>
    $( "#select_change" ).change(function() {
        $("#btn_submit").css("display", "block");
});
</script>
@endsection
