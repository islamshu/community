@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> طلبات التسويق بالعمولة  </h4>
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

                                <div class="card-content">
                                    <div class="card-body">
                                        

                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                                    aria-controls="home" aria-expanded="true">جميع الطلبات  <span style="background: #f8a1a1;width: 20px;text-align: center;border-radius: 21%;">{{ $banks->count() }}</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile"
                                                    aria-controls="profile" aria-expanded="false">الطلبات المقبولة <span style="background: #f8a1a1;width: 20px;text-align: center;border-radius: 21%;">{{ $done->count() }}</span></a>
                                            </li>
                                            
                                            <li class="nav-item">
                                                <a class="nav-link" id="stati-tab" data-toggle="tab" href="#stati"
                                                    aria-controls="stati" aria-expanded="false">الطلبات المعلقة <span style="background: #f8a1a1;width: 20px;text-align: center;border-radius: 21%;">{{ $progress->count() }}</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="about-tab" data-toggle="tab" href="#about"
                                                    aria-controls="about" aria-expanded="false">الطلبات المرفوضة <span style="background: #f8a1a1;width: 20px;text-align: center;border-radius: 21%;">{{ $regiect->count() }}</span></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel " class="tab-pane active" id="home"
                                                aria-labelledby="home-tab" aria-expanded="true">
                                                @include('dashboard.banks._all')
                                            </div>
                                            <div class="tab-pane " id="profile" role="tabpanel"
                                                aria-labelledby="profile-tab" aria-expanded="false">
                                                @include('dashboard.banks._done')

                                            </div>
                                            <div class="tab-pane" id="stati" role="tabpanel"
                                            aria-labelledby="stati-tab" aria-expanded="false">
                                            @include('dashboard.banks._progress')
                                            </div>
                                            <div class="tab-pane" id="about" role="tabpanel"
                                                aria-labelledby="about-tab" aria-expanded="false">
                                                @include('dashboard.banks._rejected')
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>





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
        $('#have_website').change(function() {
            let v = $(this).val();
            if (v == 1) {
                $('.site_url').css('display', 'block');
                $('#site_url').prop('required', true);
            } else {
                $('.site_url').css('display', 'none');
                $('#site_url').prop('required', false);
            }
        })
    </script>
@endsection
