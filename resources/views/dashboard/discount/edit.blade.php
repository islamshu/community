@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> تعديل كود خصم   </h4>
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
                                    action="{{ route('discountcode.update',$discount->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>العنوان  </label>
                                                <input type="string" name="title" value="{{ $discount->title }}" class="form-control" required >
                                            </div>
                                        
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>يبدأ في   </label>
                                                <input type="date" name="start_at" value="{{ $discount->start_at }}" class="form-control" required >
                                            </div>
                                            <div class="col-md-6">
                                                <label>ينتهي في  </label>
                                                <input type="date" name="end_at" value="{{ $discount->end_at }}" class="form-control" required >
                                            </div>                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label> نوع الخصم  </label>
                                                <select name="discount_type" class="form-control" required id="">
                                                    <option value="" selected disabled>اختر نوع الخصم</option>
                                                    <option value="rate" @if($discount->discount_type == 'rate') selected @endif>نسبة</option>
                                                    <option value="fixed" @if($discount->discount_type == 'fixed') selected @endif>ثابت</option>

                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label> قيمة الخصم  </label>
                                                <input type="number" value="{{ $discount->discount_value }}" name="discount_value" class="form-control" required >
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
