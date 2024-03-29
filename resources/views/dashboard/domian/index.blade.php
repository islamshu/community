@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> المجالات </h4>
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
                                @can('create-ScopeMember')
                                <a href="{{ route('domians.create') }}" class="btn btn-success">انشاء مجال جديد</a>
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
                                                <th>عنوان  </th>
                                                <th>العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($domians as $item)
                                            <tr>
                    
                                                <td>{{ $item->title }}</td>
                                                <td>
                                                    @can('update-ScopeMember')
                                                    <a href="{{ route('domians.edit', $item->id) }}" class="btn btn-success"><i
                                                            class="fa fa-edit"></i></a>
                                                            @endcan
                                                            @can('destroy-ScopeMember')
                                                            <form style="display: inline"
                                                            action="{{ route('domians.destroy', $item->id) }}"
                                                            method="post">
                                                            @method('delete') @csrf
                                                            <button type="submit" class="btn btn-danger delete-confirm"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                        @endcan
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
