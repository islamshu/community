@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> تعديل بوابة     </h4>
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
                                    action="{{ route('payments.update',$payment->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>صورة البوابة</label>
                                                <input type="file" name="image" class="form-control image"  >
                                                <div class="form-group">
                                                    <img src="{{ asset('uploads/'.$payment->image) }}" style="width: 100px"
                                                        class="img-thumbnail image-preview" alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>قيمة البوابة    </label>
                                                <select name="value" class="form-control select2" required  id="">
                                                    <option value="" disabled>يرجى قيمة البوابة </option>
                                                    <option value="visa" @if($payment->value =='visa') selected @endif>Visa</option>
                                                    <option value="paypal"  @if($payment->value =='paypal') selected @endif>Paypal</option>
                                                    <option value="stripe"   @if($payment->value =='stripe') selected @endif>stripe</option>

                                                </select>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>اسم البوابة  </label>
                                                <input type="string" value="{{ $payment->name }}" name="title" class="form-control" required >
                                            </div>
                                            <div class="col-md-6">
                                                <label>العملات التابعة للبوابة  </label>
                                                <select name="currencie_ids[]" class="form-control select2" required multiple id="">
                                                    <option value="" disabled>يرجى اختيار العملات</option>
                                                    @foreach ($currencies as $item)
                                                        <option value="{{ $item->id }}" @if(in_array($item->id,json_decode($payment->currencie_ids))) selected @endif>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
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
