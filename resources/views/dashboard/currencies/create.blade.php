@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> انشاء عملة جديدة   </h4>
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
                                    action="{{ route('currencies.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>اسم العملة  </label>
                                                <input type="string" name="title" class="form-control" required >
                                            </div>
                                            
                                            <br>
                                            <div class="col-md-6" id="pricecid" >
                                                <label>السعر  </label>
                                                <input
                                                class="form-control"
                                                name="amount_as_dollar"
                                                required
                                                className="center-align"
                                                type="text"
                                                pattern="(^[0-9]{0,2}$)|(^[0-9]{0,2}\.[0-9]{0,5}$)"
                                                step="any"
                                                validate="true"
                                                />  
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-md-6">
                                                <label>رمز العملة   </label>
                                                <input type="string" name="symbol" class="form-control" required >
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
