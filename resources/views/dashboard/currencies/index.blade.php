@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> العملات </h4>
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

                                 @can('create-currencies')
                                 <a href="{{ route('currencies.create') }}" class="btn btn-success">انشاء عملة جديدة</a>
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
                                                <th>اسم العملة</th>
                                                <th>الحالة   </th>
                                                <th>  القيمة مقابل الدولار</th>
                                                <th>رمز العملة</th>
                                                <th>الاجراءات   </th>

                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($currencies as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->name }} </td>
                                                    <td>
                                                        <input type="checkbox" data-id="{{ $item->id }}" name="in_home"
                                                            class="js-switch" {{ $item->status == 1 ? 'checked' : '' }}>
                                                    </td>
                                                    <td>{{ $item->value_in_dollars }} </td>
                                                    <td>{{ $item->symbol }}</td>
                                                    <td>
                                                        @can('update-currencies')

                                                        <a href="{{ route('currencies.edit',$item->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i>  </a>
                                                        @endcan
                                                        @can('destroy-currencies')

                                                        <form style="display: inline"
                                                            action="{{ route('currencies.destroy', $item->id) }}"
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
<script>
    $(document).ready(function() {
        $("#storestable").on("change", ".js-switch", function() {
            let status = $(this).prop('checked') === true ? 1 : 0;
            let currencie_id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('currencies.update.status') }}',
                data: {
                    'status': status,
                    'currencie_id': currencie_id
                },
                success: function(data) {
                    console.log(data.message);
                }
            });
        });
    });
</script>
@endsection
