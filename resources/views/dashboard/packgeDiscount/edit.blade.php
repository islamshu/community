@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> انشاء عضو جديد   </h4>
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
    
                                <form method="post" action="{{ route('packageDiscount.update',$packge->id) }}">
                                    @csrf
                                    @method('put')
                                  
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">نوع الباقة   :</label>
                                        <select name="package_id" required class=" form-control " id="peroid">
                                          <option value="" selected >اختر نوع الباقة </option>
                                          @foreach (App\Models\Package::get() as $item)
                                          <option value="{{ $item->id }}" @if($packge->package_id == $item->id) selected @endif  > {{ $item->title }}  </option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">يبدأ في     :</label>
                                        <input type="date" name="start_at" value="{{ $packge->start_at }}" required class="form-control" >
                                      </div>
                                      <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">   ينتهي في   :</label>
                                        <input type="date" name="end_at" value="{{ $packge->end_at }}"   class="form-control" >
                                      </div>
                                      <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">نسبة الخصم (%)    :</label>
                                        <input type="number" name="discount"  value="{{ $packge->discount }}" required class="form-control" >
                                      </div>
                                      
                                    <div class="col-md-6">
                                
                                        <input type="submit" value="ارسال" class="btn btn-info">
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


