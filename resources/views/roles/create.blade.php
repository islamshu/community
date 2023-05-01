@extends('layouts.backend')



@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-md-6 col-sm-12">
                    <h1>اضافة صلاحية</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item">
                                <a href="{{ route('roles.index') }}">
                                    الصلاحية
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">اضافة صلاحية</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <form method="post" action="{{ route('roles.store') }}">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="body">

                            <div class="form-group col-lg-6 col-md-6">
                                <label for="basic-url" @if ($errors->has('display_name')) style="color: red" @endif>
                                    اسم الصلاحية
                                </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="icon-pencil"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="اسم الصلاحية"
                                        name="display_name" aria-label="display_name" aria-describedby="basic-addon1"
                                        required="required"
                                        @if ($errors->has('display_name')) style="border: 1px solid red" @endif>
                                </div>
                                @if ($errors->has('display_name'))
                                    <p style="color: red">{{ $errors->first('display_name') }}</p>
                                @endif

                            </div>

                        </div>



                    </div>
            </div>
            <div class="card">
                <div class="header">
                    <h2> الصلاحيات</h2>
                </div>
                <div class="body">
                    <div class="card-columns">
                        @foreach ($uiPermission as $key => $permissionGroup)
                            <div class="card  bg-warning mb-3">
                                <div class=" card-header">{{ $key }}</div>
                                <ul class="list-group list-group-flush">
                                    @foreach ($permissionGroup as $permission)
                                        <li class="list-group-item">
                                            <div class="fancy-checkbox">
                                                <label>
                                                    <input type="checkbox" name="permission_ids[]"
                                                        value="{{ $permission->id }}">
                                                    <span>{{ $permission->name }}</span>

                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div><!-- ./card -->
                        @endforeach

                        @php
                            
                        @endphp

                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="submit" name="Save Changes" class="btn btn-success" value="{{ __('حفظ') }}">
                <a href="{{ route('roles.index') }}" class="btn btn-default">
                    {{ __('Cancel') }}
                </a>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
