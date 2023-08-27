@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> الباقات </h4>
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
                                 @can('create-package')
                                <a href="{{ route('packages.create') }}" class="btn btn-success">انشاء باقة جديدة</a>
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
                                                <th> السعر  </th>
                                                <th>فقط للادارة ؟</th>
                                                <th>الاجراءات   </th>

                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($packages as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                    <td>
                                                        
                                                        <img src="{{ asset('uploads/'.$item->image) }}" width="50" height="50" alt="">
                                                        
                                                    </td>
                                                    <td>{{ $item->title }} </td>
                                                    <td>{{ $item->price }} $ </td>

                                                    <td>
                                                        <input type="checkbox" data-id="{{ $item->id }}" name="in_home"
                                                            class="js-switch" {{ $item->for_admin == 1 ? 'checked' : '' }}>
                                                    </td>

                                                    <td>
                                                        @can('update-package')

                                                        <a href="{{ route('packages.edit',$item->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i>  </a>
                                                        @endcan
                                                        @can('destroy-package')

                                                        <form style="display: inline"
                                                            action="{{ route('packages.destroy', $item->id) }}"
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
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('packge.update.status') }}',
                data: {
                    'for_admin': status,
                    'packge_id': userId
                },
                success: function(data) {
                    console.log(data.message);
                }
            });
        });
    });
    
</script>
@endsection
