@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> أكواد الخصم </h4>
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
                                 @can('create-discount')
                                <a href="{{ route('discountcode.create') }}" class="btn btn-success">انشاء كود خصم جديد </a>
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
                                                <th>اسم الكود</th>
                                                <th>الكود   </th>
                                                <th> يبدأ في  </th>
                                                <th> ينتهي في  </th>
                                                <th>قيمة الخصم</th>
                                                <th>الاجراءات   </th>

                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($discount as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                    <td>{{ $item->title }}</td>
                                                    <td>{{ $item->code }} </td>
                                                    <td>{{ $item->start_at }} </td>
                                                    <td>{{ $item->end_at }} </td>
                                                    <td> <button class="btn btn-info">{{ $item->discount_value  }}{{ $item->discount_type == 'rate' ? '%' : '$' }} </button></td>

                                                    <td>
                                                        @can('update-discount')

                                                        <a href="{{ route('discountcode.edit',$item->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i>  </a>
                                                        @endcan
                                                        @can('destroy-discount')

                                                        <form style="display: inline"
                                                            action="{{ route('discountcode.destroy', $item->id) }}"
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
