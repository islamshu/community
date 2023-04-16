@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> انشاء مجال جديد    </h4>
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
                                <form id="edit_form_new" method="post" action="{{ route('domians.store') }}" style="direction: rtl">
                                    @csrf
                                
                                    
                                    <div class="row">
                                        
                                        <div class="form-group col-md-8">
                                            <label for="email"> المجال : <span class="required"></span></label>
                                            <input type="text" name="title" required class="form-control"
                                                value="{{ old('title')}}" id="title">
                                        </div>
                                       
                                    </div>
                                       
                                
                                
                                
                                
                                
                                
                                    <br>
                                
                                
                                    <button class="btn btn-info" type="submit">حفظ</i></button>
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
    
@endsection
