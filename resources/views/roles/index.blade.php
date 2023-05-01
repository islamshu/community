@extends('layouts.backend')


@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row clearfix">
            <div class="col-md-6 col-sm-12">
                <h1>صلاحيات</h1>  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
	                    <li class="breadcrumb-item active"><a href="#">صلاحيات</a></li>
                    </ol>
                </nav>
            </div>            
            <div class="col-md-6 col-sm-12 text-right hidden-xs">
                <a href="{{route('roles.create')}}" class="btn btn-success">
                    <i class="fa fa-plus"></i> اضف صلاحية
                </a>
            </div>
        </div>
    </div>
    
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example dataTable table-custom spacing5">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>الاجراءات</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>الاسم</th>
                                    <th>الاجراءات</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($roles as $one_role)
                                <tr>
                                    <td>{{$one_role->name}}</td>
                                
                                    <td>
                                      
                                        <a href="{{route('roles.edit',$one_role->id)}}" class="btn btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
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
</div>
@endsection