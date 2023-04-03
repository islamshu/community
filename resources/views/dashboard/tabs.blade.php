@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> تعديل عرض التابات   </h4>
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
                                                <label>الجلسات</label>
                                                <select name="videos" class="form-control" id="">
                                                    <option value="" disabled selected>اختر</option>
                                                    <option value="1">عرض</option>
                                                    <option value="0">اخفاء</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>الادوات</label>
                                                <select name="tools" class="form-control" id="">
                                                    <option value="" disabled selected>اختر</option>
                                                    <option value="1">عرض</option>
                                                    <option value="0">اخفاء</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>الخدمات</label>
                                                <select name="services" class="form-control" id="">
                                                    <option value="" disabled selected>اختر</option>
                                                    <option value="1">عرض</option>
                                                    <option value="0">اخفاء</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>الفيديوهات التعليمية</label>
                                                <select name="videos_leraning" class="form-control" id="">
                                                    <option value="" disabled selected>اختر</option>
                                                    <option value="1">عرض</option>
                                                    <option value="0">اخفاء</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>الاعضاء </label>
                                                <select name="members" class="form-control" id="">
                                                    <option value="" disabled selected>اختر</option>
                                                    <option value="1">عرض</option>
                                                    <option value="0">اخفاء</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>العروض </label>
                                                <select name="offers" class="form-control" id="">
                                                    <option value="" disabled selected>اختر</option>
                                                    <option value="1">عرض</option>
                                                    <option value="0">اخفاء</option>
                                                </select>
                                            </div>
                                           
                                        </div>
                                       
                                        <br>
                                        
                                        <br>
                                      
                                       
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
