@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> انشاء عضو   </h4>
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
                                                    <img src="{{ asset('uploads/'.$user->image) }}" style="width: 100px" class="img-thumbnail image-preview" alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="username">الاسم:</label>
                                                    <input type="text" class="form-control" id="username" value="{{ $user->name }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">البريد الاكتروني:</label>
                                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" aria-expanded="true">المعلومات الشخصية</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" aria-expanded="false">المدفوعات</a>
                                            </li>
                                          
                                            <li class="nav-item">
                                                <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" aria-controls="about" aria-expanded="false">الجلسات</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane" id="home" aria-labelledby="home-tab" aria-expanded="true">
                                                @include('dashboard.users._show')
                                            </div>
                                            <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab" aria-expanded="false">
                                                @include('dashboard.users._subs')

                                            </div>
                                           
                                            <div class="tab-pane" id="dropdown2" role="tabpanel" aria-labelledby="dropdown2-tab" aria-expanded="false">
                                                <p>Chocolate croissant cupcake croissant jelly donut. Cheesecake toffee apple pie chocolate bar biscuit tart croissant. Lemon drops danish cookie. Oat cake macaroon icing tart lollipop cookie sweet bear claw.</p>
                                            </div>
                                            <div class="tab-pane" id="about" role="tabpanel" aria-labelledby="about-tab" aria-expanded="false">
                                                <p>Carrot cake dragée chocolate. Lemon drops ice cream wafer gummies dragée. Chocolate bar liquorice cheesecake cookie chupa chups marshmallow oat cake biscuit. Dessert toffee fruitcake ice cream powder tootsie roll cake.</p>
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

    </div>
@endsection
@section('script')
    <script>
        $('#have_website').change(function(){
           let v =  $(this).val();
           if(v == 1){
            $('.site_url').css('display','block');
            $('#site_url').prop('required',true);
           }else{
            $('.site_url').css('display','none');
            $('#site_url').prop('required',false);
           }
        })
    </script>
@endsection
