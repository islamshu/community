@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> المقالات </h4>
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
                                @can('create-blogs')
                                <a href="https://dashboard.arabicreators.com/blogs" target="_blank" class="btn btn-success">انشاء مقال جديد</a>
                                @endcan
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
                                                <th>#</th>
                                                <th>الصورة</th>
                                                <th>العنوان   </th>
                                                <th> تاريخ النشر  </th>
                                                <th>الاجراءات</th>


                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($blogs as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                    <td>
                                                        
                                                        <img src="{{ $item['image'] }}" width="50" height="50" alt="">
                                                        
                                                    </td>
                                                    <td>{{ $item['title'] }} </td>
                                                    <td>{{ $item['publish_time'] }}</td>
                                                    <td>
                                                    <a href="{{ route('show_blog',$item['slug']) }}" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                                                    



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
