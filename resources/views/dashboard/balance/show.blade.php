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
                                        <div class="row">
                                            @php
                                                $array_type = ($balace->payment_detiles);
                                                $replacedData = str_replace(['{', '}'], ['[', ']'], $array_type);
                                                $bankArray = json_decode($replacedData);


                                            @endphp
                                            {{ dd((($bankArray))) }}
                                            <div class="col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="username">طريقة استلام :</label>
                                                    <input type="text" value="{{ $balace->method_type }}" class="form-control" disabled name="" id="">
                                                </div>
                                            </div>
                                                <div class="col-md-6 mt-2">
                                                    @if($balace->status != 1)
                                                    <form action="{{ route('change_status',$balace->id) }}" method="post">
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
                                                        <div class="col-md-8">
                                                            <label class="">الرسالة </label>
                                                            <input type="text" value="{{ $balace->error_message }}" name="message" required class="form-control">
                    
                                                        </div>
                                                        <div class="col-md-6 mt-10" style="display: none" id="btn_submit">
                                                            <input type="submit"  class="btn btn-info" value="تأكيد">
                                                        </div>
        
                                                    </form>
                                                    @endif
        
                                                </div>
                                        </div>
                                        <br> <br>
                                        @if($balace->method_type == 'paypal')
                                        <fieldset style="width:80%">
                                            <legend>بيانات الباي بال:</legend>
                                            <div class="col-md-6 mt-2">
                                                <label>البريد الاكتروني </label>
                                                <input disabled type="email" value="{{ $balace->paypal_email }}"
                                                    name="email" class="form-control" required>
                                            </div>
                                        </fieldset>
                                        @endif
                                        <br>
                                        @if($balace->method_type == 'westron')
                                        <fieldset style="width:80%">
                                            <legend>بيانات الويسترن يونيون :</legend>
                                            <div class="col-md-6 mt-2">
                                                <label>الاسم كامل </label>
                                                <input disabled type="email" value="{{ $balace->fullname }}" name="email"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>رقم الهوية </label>
                                                <input disabled type="email" value="{{ $balace->persionID }}" name="email"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>صورة الهوية </label>
                                                <div class="form-group">
                                                    <img src="{{ asset('uploads/' . $balace->Idimage) }}" style="width: 100px"
                                                        class="img-thumbnail image-preview" alt="">
                                                        @if($balace->Idimage != null)
                                                        <a target="_blank" href="{{ asset('uploads/' . $balace->Idimage) }}">مشاهدة</a>
                                                        @endif
                                                    </div>
                                            </div>
                                        </fieldset>
                                        @endif
                                        <br>
                                        @if($balace->method_type == 'bank')

                                        <fieldset style="width:80%">
                                            <legend>بيانات البنك :</legend>
                                            <div class="col-md-6 mt-2">
                                                <label>اسم البنك </label>
                                                <input disabled type="email" value="{{ $balace->balace_name }}" name="email"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>رقم الايبان </label>
                                                <input disabled type="email" value="{{ $balace->ibanNumber }}"
                                                    name="email" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>اسم صاحب الحساب </label>
                                                <input disabled type="email" value="{{ $balace->owner_name }}"
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
