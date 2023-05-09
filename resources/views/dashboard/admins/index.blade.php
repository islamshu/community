@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> الادارين </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                                 <br>
                                <a href="{{ route('admins.create') }}" class="btn btn-success">انشاء اداري جديد</a>

                            </div>

                            <div class="card-content collapse show">

                                <div class="card-body card-dashboard">
                                    @include('dashboard.parts._error')
                                    @include('dashboard.parts._success')

                                    <br>

                                    <br>
                                    <table class="table table-striped table-bordered zero-configuration" id="storestable">


                                        <br>
                                        <thead>
                                            <tr>
                                                <th>الاسم  </th>
                                                <th>البريد الاكتروني  </th>
                                                <th>الصلاحية   </th>
                                                <th>اضيف بواسطة</th>
                                                <th>العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($admins as $item)
                                            <tr>
                    
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                {{-- json_encode($array , JSON_UNESCAPED_UNICODE); --}}

                                                <td>{!! $item->getRoleNames()->toJson(JSON_UNESCAPED_UNICODE) !!}</td>
                                                <td>{{ @$item->admin->name }}</td>

                                                <td>
                                                    <a href="{{ route('admins.edit', $item->id) }}" class="btn btn-success"><i
                                                            class="fa fa-edit"></i></a>
                                                           
                                                <td>
                    
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>
@endsection
@section('script')

@endsection
