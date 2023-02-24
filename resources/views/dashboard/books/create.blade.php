@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> انشاء كتاب جديد   </h4>
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
                                    action="{{ route('books.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>صورة الكتاب</label>
                                                <input type="file" name="image" class="form-control image" required >
                                                <div class="form-group">
                                                    <img src="" style="width: 100px"
                                                        class="img-thumbnail image-preview" alt="">
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>العنوان  </label>
                                                <input type="string" name="title" class="form-control" required >
                                            </div>
                                            <div class="col-md-6">
                                                <label>مجاني ام مدفوع  </label>
                                                <select name="type" id="type_price" required class="form-control" >
                                                    <option value="" disabled selected>اختر</option>
                                                    <option value="free">مجاني</option>
                                                    <option value="unfree">مدفوع</option>

                                                </select>
                                            </div>
                                            <br>
                                            <div class="col-md-6" id="pricecid" style="display: none">
                                                <label>السعر  </label>
                                                <input type="number" id="price" name="price" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>الوصف  </label>
                                                <textarea name="description" required class="form-control" id="" cols="30" rows="10"></textarea>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>ملف النسخة المجانية </label>
                                                <input type="file" name="demo_file" class="form-control " required >
                                               
                                            </div>
                                            <div class="col-md-6">
                                                <label>ملف النسخة المدفوعة </label>
                                                <input type="file" name="full_file" class="form-control " required >
                                               
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
            $("#price").val('');

        }else{
            $("#pricecid").css("display", "none");
            $("#price").prop('required',false); 
            $("#price").val('');

        }
    });
</script>
@endsection
