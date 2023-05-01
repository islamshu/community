@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> الشركاء </h4>
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
                                @can('create-partner')
                                <a href="{{ route('partners.create') }}" class="btn btn-success">انشاء شريك جديد</a>
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
                                                <th>الاجراءات   </th>

                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($partners as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                    <td>
                                                        
                                                        <img src="{{ asset('uploads/'.$item->image) }}" width="50" height="50" alt="">
                                                        
                                                    </td>
                                                    <td>{{ $item->title }} </td>

                                                    <td>
                                                        @can('update-partner')
                                                        <a href="{{ route('partners.edit',$item->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i>  </a>
                                                        @endcan
                                                        @can('destroy-partner')
                                                        <form style="display: inline"
                                                            action="{{ route('partners.destroy', $item->id) }}"
                                                            method="post">
                                                            @method('delete') @csrf
                                                            <button type="submit" class="btn btn-danger delete-confirm"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                        @endcan
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
