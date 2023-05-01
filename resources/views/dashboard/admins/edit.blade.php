@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> تعديل الاداري    </h4>
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
                                    action="{{ route('admins.update',$admin->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>الاسم </label>
                                                <input type="text" name="name" value="{{ $admin->name }}" class="form-control" required  >
                                               
                                            </div>
                                            <div class="col-md-6">
                                                <label>البريد الاكتروني  </label>
                                                <input type="email" value="{{ $admin->email }}" name="email" class="form-control" required >
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>كلمة المرور   </label>
                                                <input type="password"  name="password" class="form-control"  >
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>الصلاحية    </label>
                                                <select name="role" class="form-control" id="" required>
                                                    <option value="">اختر الصلاحية</option>

                                                    @foreach ($roles as $item)
                                                    <option value="{{ $item->name }}" @if(in_array($item->name,$admin->getRoleNames()->toArray())) selected @endif>{{ $item->name }}</option>
 
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                        </div>
                                        
                                       
                                        
                                       
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
