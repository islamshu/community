@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> تعديل السؤال    </h4>
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
                                    action="{{ route('faqs.update',$faq->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                      
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label> {{ __('السؤال') }} :</label>
                                                <input type="text" name="question" value="{{ $faq->question }}" id="qus" class="form-control form-control-solid"
                                                    placeholder="اضف سؤال" required />
                                            </div>
                                       
                                            <div class="form-group col-md-12">
                                                <label>{{ __('الاجابة') }} :</label>
                                                <textarea name="answer" class="form-control ckeditor" required id="" cols="30" rows="5">{{ $faq->answer }}</textarea>
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
    $('#type_price').change(function(){
        var typeprice = $(this).val();
        if(typeprice !='free'){
            $("#pricecid").css("display", "block");
            $("#price").prop('required',true);
        }else{
            $("#pricecid").css("display", "none");
            $("#price").prop('required',false); 
        }
    });
</script>
@endsection
