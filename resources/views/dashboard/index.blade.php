@extends('layouts.backend')
@section('content')
   <div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <a href="" data-toggle="modal" data-target="#all_company">
                            <div class="media-body text-left">
                                <h3 class="primary">{{ App\Models\User::where('is_paid',1)->count() }}</h3>
                                <h6>عدد المشتركين</h6>
                            </div>
                        </a>
                        <div>
                            <i class="icon-user-follow primary font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-primary" role="progressbar" style="width: 80%"
                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <a href="" data-toggle="modal" data-target="#all_company">
                            <div class="media-body text-left">
                                <h3 class="success">{{ App\Models\User::count() }}</h3>
                                <h6>عدد المسجلين</h6>
                            </div>
                        </a>
                        <div>
                            <i class="icon-user-follow success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 80%"
                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card pull-up">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <a href="" data-toggle="modal" data-target="#all_company">
                            <div class="media-body text-left">
                                <h3 class="info">{{ App\Models\Community::count() }}</h3>
                                <h6>عدد المجتمعات</h6>
                            </div>
                        </a>
                        <div>
                            <i class="icon-user-follow info font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%"
                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
@endsection
