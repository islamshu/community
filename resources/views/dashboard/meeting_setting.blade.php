@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> تعديل الجلسة القادمة      </h4>
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
                                    action="{{ route('add_general_meeting') }}" enctype="multipart/form-data">
                                    @csrf 
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label>تاريخ الجلسة</label>
                                                {{-- {{ dd(now() , get_general_value('meeting_date')) }} --}}
                                                <input type="datetime-local" class="form-control" value="{{ get_general_value('meeting_date') }}"  name="general[meeting_date]" id="">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>مدة الجلسة بالدقائق </label>
                                                <input type="number" class="form-control" value="{{ get_general_value('meeting_time') }}"  name="general[meeting_time]" id="">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>مدة دورة التكرار      </label>
                                                <input type="number" class="form-control" value="{{ get_general_value('peroid_number') }}"  name="general[peroid_number]" id="">
                                            </div>
        
                                            <div class="col-md-6 mt-2">
                                                <label>نوع مدة التكرار    </label>
                                                <select name="general[peroid_type]" class="form-control" id="">
                                                <option value="" disabled>اختر نوع التكرار</option>
                                                <option value="day" @if(get_general_value('peroid_type') == 'day') selected @endif>يوم</option>
                                                <option value="week" @if(get_general_value('peroid_type') == 'week') selected @endif>اسبوع</option>
                                                <option value="month" @if(get_general_value('peroid_type') == 'month') selected @endif>شهر </option>
                                                </select>

                                            </div>
                                            {{-- <div class="col-md-6 mt-2">
                                                <label>رابط الجلسة</label>
                                                <input type="text" class="form-control" value="{{ get_general_value('meeting_url') }}"   name="general[meeting_url]" id="">
                                            </div> --}}
                                            
                                           
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
