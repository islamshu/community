@extends('layouts.backend')


@section('content')

<div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-md-6 col-sm-12">
                    <h1>تعديل الصلاحية</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        
                        <li class="breadcrumb-item">
                            <a href="{{route('roles.index')}}">
                                الصلاحيات
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">تعديل الصلاحية</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <form method="post" action="{{route('roles.update',$role->id)}}">
                    {{csrf_field()}} @method('put')
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
                                    <input type="text" value="{{ $role->name }}" class="form-control" placeholder="اسم الصلاحية"
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
                    <div class="card" >
                        <div class="header">
                            <h2>{{__('الادوار')}}</h2>
                        </div>
                        <div class="body">
                            <div class="card-columns">
                              @foreach($uiPermission as $key => $permissionGroup)
                                    <div class="card  bg-warning mb-3">
                                        <div class=" card-header">{{ $key }}</div>
                                        <ul class="list-group list-group-flush">
                                        @foreach( $permissionGroup as $permission )
                                            <li class="list-group-item">
                                                <div class="fancy-checkbox">
                                                   <label>
                                                        <input type="checkbox" name="permission_ids[]" value="{{$permission->id}}"
                                                        @foreach($role->permissions as $role_permession)
                                                        @if($role_permession->id == $permission->id)
                                                            checked="checked"
                                                        @endif
                                                        @endforeach
                                                        >
                                                           
                                                        <span>{{$permission->name}}</span>
                                                        
                                                     </label>
                                                </div>
                                            </li>
                                        @endforeach
                                        </ul>
                                    </div><!-- ./card -->
                                @endforeach

                                @php
                                /*
                                @foreach($all_permissions as $one_permission)
                                
                                    <div class="col-lg-3 col-md-12">
                                        <div class="fancy-checkbox">
                                            <label>
                                                
                                                <input type="checkbox" name="permission_ids[]" value="{{$one_permission->id}}"
                                                @foreach($role->permissions as $role_permession)
                                                   @if($role_permession->id == $one_permission->id)
                                                       checked="checked"
                                                   @endif
                                                @endforeach
                                                >
                                                @if(Auth::user()->hasRole('Admin'))
                                                <span>{{$one_permission->display_name}}</span>
                                                @endif
                                                 @if(Auth::user()->hasRole('Enterprises|Vendors'))
                                                <span>{{$one_permission->Permission->display_name}}</span>
                                                 @endif
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                */
                                @endphp

                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="submit" name="Save Changes" class="btn btn-success" value="{{__('حفظ')}}">
                        <a href="{{route('roles.index')}}" class="btn btn-default">
                             {{__('الغاء')}}
                         </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
<script src="https://unpkg.com/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"></script>
<script>
$('.grid').masonry({
  itemSelector: '.grid-item',
  columnWidth: '.grid-sizer',
  percentPosition: true
});
</script>
@endsection