@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> {{ $user->name }}  </h4>
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
                                            <div class="col-md-6 mt-2">
                                                <div class="form-group">
                                                    <img src="{{ asset('uploads/' . $user->image) }}" style="width: 100px"
                                                        class="img-thumbnail image-preview" alt="">
                                                       <button class="btn  {{ $user->is_paid == 1 ? 'btn-success' : 'btn-danger' }}"> {{ $user->is_paid == 1 ? 'مدفوع' : 'غير دافع' }}</button>
                                                       <button class="btn  {{ $user->email_verified_at != null ? 'btn-success' : 'btn-danger' }}"> {{ $user->email_verified_at != null ? 'تم التحقق' : 'غير متحقق ' }}</button>
                                                    <br>
                                                       تاريخ الانضمام : {{ $user->created_at->format('Y-m-d') }} <br>
                                                       @if($user->is_paid == 1)
                         تاريخ بدء الاشتراك : {{ $user->subscription->last()->start_at }} <br>
                         تاريخ نهاية الاشتراك : {{ $user->subscription->last()->end_at }} <br>
                         @endif

                                                    </div>
                                                    @foreach ($user->soical_new as $item)
                                                    {{ dd($item) }}
                                                       <a target="_blank"  href="{{ $item->url .'/'.$item->user_name }}"><img width="30" height="30" src="{{asset('socail/'.$item->name.'.svg')  }}"  alt=""></a> 
                                                    @endforeach
                                                {{-- @if (@$user->soical->facebook != null)
                                                    <a target="_blacnk"
                                                        href="https://www.facebook.com/{{ @$user->soical->facebook }}"><img
                                                            src="https://cdn-icons-png.flaticon.com/512/49/49354.png"
                                                            width="30" height="30" alt=""></a>
                                                @endif
                                                @if (@$user->soical->instagram != null)
                                                    <a target="_blacnk"
                                                        href="https://www.instagram.com/{{ @$user->soical->instagram }}"><img
                                                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/2048px-Instagram_icon.png"
                                                            width="30" height="30" alt=""></a>
                                                @endif
                                                @if (@$user->soical->twitter != null)
                                                    <a target="_blacnk"
                                                        href="https://www.twitter.com/{{ @$user->soical->twitter }}"><img
                                                            src="https://cdn-icons-png.flaticon.com/512/145/145812.png"
                                                            width="30" height="30" alt=""></a>
                                                @endif
                                                @if (@$user->soical->pinterest != null)
                                                    <a target="_blacnk"
                                                        href="https://www.pinterest.com/{{ @$user->soical->pinterest }}"><img
                                                            src="https://cdn-icons-png.flaticon.com/512/145/145808.png"
                                                            width="30" height="30" alt=""></a>
                                                @endif
                                                @if (@$user->soical->snapchat != null)
                                                    <a target="_blacnk"
                                                        href="https://www.snapchat.com/{{ @$user->soical->snapchat }}"><img
                                                            src="https://www.iconpacks.net/icons/2/free-snapchat-logo-icon-2437-thumb.png"
                                                            width="30" height="30" alt=""></a>
                                                @endif
                                                @if (@$user->soical->linkedin != null)
                                                    <a target="_blacnk"
                                                        href="https://www.linkedin.com/{{ @$user->soical->linkedin }}"><img
                                                            src="https://cdn3.iconfinder.com/data/icons/inficons/512/linkedin.png"
                                                            width="30" height="30" alt=""></a>
                                                @endif
                                                @if (@$user->soical->whatsapp != null)
                                                    <a target="_blacnk"
                                                        href="https://api.whatsapp.com/send/?phone={{ @$user->soical->whatsapp }}"><img
                                                            src="https://cdn3.iconfinder.com/data/icons/2018-social-media-logotypes/1000/2018_social_media_popular_app_logo-whatsapp-64.png"
                                                            width="30" height="30" alt=""></a>
                                                @endif
                                                @if (@$user->soical->telegram != null)
                                                    <a target="_blacnk"
                                                        href="https://www.t.me.com/{{ @$user->soical->telegram }}"><img
                                                            src="https://cdn3.iconfinder.com/data/icons/social-icons-33/512/Telegram-64.png"
                                                            width="30" height="30" alt=""></a>
                                                @endif
                                                @if (@$user->soical->youtube != null)
                                                <a target="_blacnk"
                                                    href="{{ @$user->soical->youtube }}"><img
                                                        src="https://cdn3.iconfinder.com/data/icons/2018-social-media-logotypes/1000/2018_social_media_popular_app_logo_youtube-64.png"
                                                        width="30" height="30" alt=""></a>
                                                @endif --}}
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="username">الاسم:</label>
                                                    <input type="text" class="form-control" id="username"
                                                        value="{{ $user->name }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">البريد الاكتروني:</label>
                                                    <input type="email" class="form-control" id="email"
                                                        value="{{ $user->email }}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                                    aria-controls="home" aria-expanded="true">المعلومات الشخصية</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile"
                                                    aria-controls="profile" aria-expanded="false">المدفوعات</a>
                                            </li>
                                            
                                            <li class="nav-item">
                                                <a class="nav-link" id="stati-tab" data-toggle="tab" href="#stati"
                                                    aria-controls="stati" aria-expanded="false">لاحصائيات</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="about-tab" data-toggle="tab" href="#about"
                                                    aria-controls="about" aria-expanded="false">الجلسات</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel " class="tab-pane active" id="home"
                                                aria-labelledby="home-tab" aria-expanded="true">
                                                @include('dashboard.users._show')
                                            </div>
                                            <div class="tab-pane " id="profile" role="tabpanel"
                                                aria-labelledby="profile-tab" aria-expanded="false">
                                                @include('dashboard.users._subs')

                                            </div>
                                            <div class="tab-pane" id="stati" role="tabpanel"
                                            aria-labelledby="stati-tab" aria-expanded="false">
                                            @include('dashboard.users._stati')
                                            </div>
                                            <div class="tab-pane" id="about" role="tabpanel"
                                                aria-labelledby="about-tab" aria-expanded="false">
                                                @include('dashboard.users._vids')
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
    </div>
    </div>
    </section>
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
    </div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $('#have_website').change(function() {
            let v = $(this).val();
            if (v == 1) {
                $('.site_url').css('display', 'block');
                $('#site_url').prop('required', true);
            } else {
                $('.site_url').css('display', 'none');
                $('#site_url').prop('required', false);
            }
        })
        
    </script>
    <script>
        var ctx2 = document.getElementById('chart4').getContext('2d');
        var chart4 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['اجمالي الرصيد', 'اجمالي الرصيد القابل للسحب'],
                datasets: [{
                    data: ['{{ $user->total_balance }}', '{{ $user->total_withdrowable }}'],
                    backgroundColor: ['#DE4F76', '#C3F2E0']
                }]
            }
        });
    </script>
    <script>
        var ctx3 = document.getElementById('chart3').getContext('2d');
        var chart3 = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['اجمالي المشاهدات', 'مجموع عمليات تسجيل الدخول','مجموع المشتركين'],
                datasets: [{
                    data: ['{{ $number_show }}', '{{ $register_user }}','{{ $paid_user }}'],
                    backgroundColor: ['#DE4F22', '#C3F247','#FEF247']
                }]
            }
        });
    </script>
    
    <script>
        var chartData = @json($chartData);

        var ctx = document.getElementById('columnChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: chartData.datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        stepSize: 1
                    }
                }
            }
        });
    </script>
     <script>
        var chartData2 = @json($chartData2);

        var ctx2 = document.getElementById('columnChart2').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: chartData2.labels,
                datasets: chartData2.datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        stepSize: 1
                    }
                }
            }
        });
    </script>


@endsection
