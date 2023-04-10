@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> بيانات موقع الفرونت</h4>
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
    
                                <form class="form" method="post"
                                    action="{{ route('add_general') }}" enctype="multipart/form-data">
                                    @csrf 
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label>صورة الموقع</label>
                                                <input type="file" class="form-control"  name="general_file[image_front]" id="">
                                            </div>
                                            
                                           
                                        </div>
                                        <video src="{{ asset('uploads/'.get_general_value('image_front')) }}"></video>
                                       
                                      
                                       
                                        <br>
                                        
                                       
                                    </div>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label>صورة الموقع</label>
                                                <input type="file" class="form-control"  name="general_file[icon_front]" id="">
                                            </div>
                                            
                                           
                                        </div>
                                        <video src="{{ asset('uploads/'.get_general_value('icon_front')) }}"></video>
                                       
                                      
                                       
                                        <br>
                                        
                                       
                                    </div>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label>البريد الاكتروني </label>
                                                <input type="text" class="form-control" value="{{ get_general_value('email') }}"  name="general[email]" id="">
                                            </div>
                                            
                                           
                                        </div>
                                       
                                      
                                       
                                        <br>
                                        
                                       
                                    </div>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label>رقم الواتس اب  </label>
                                                <input type="text" class="form-control" value="{{ get_general_value('whataspp') }}"  name="general[whataspp]" id="">
                                            </div>
                                            
                                           
                                        </div>
                                       
                                      
                                       
                                        <br>
                                        
                                       
                                    </div>


                                   
                                   
    
    
                                    <div class="form-actions left">

                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> @lang('حفظ')
                                    </button>
                                        </button>
                                    </div>
    
    
                                </form>
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
