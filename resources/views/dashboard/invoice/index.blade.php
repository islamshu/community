@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> الفواتير  </h4>
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
                                 {{-- @can('read-MemberType')
                                <a href="{{ route('members.create') }}" class="btn btn-success">انشاء نوع مستخدم جديدة</a>
                                @endcan --}}
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">انشاء فاتورة جديدة</button>


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
                                                <th>رقم الفاتورة   </th>
                                                <th>تاريخ الفاتورة   </th>
                                                <th>اسم صاحب الفاتورة   </th>
                                                <th>الاجراءات</th>

                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($invoices as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                
                                                    <td>{{ $item->code }} </td>
                                                    <td>{{ $item->start_at }} </td>
                                                    <td>{{ $item->user->name }} </td>

                                                    <td>
                                                        <a href="{{ route('invoideviewPdf',$item->code) }}" target="_blank">PDF</a>
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
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  " role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"> انشاء فاتورة</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="{{ route('invoices.store') }}">
                        @csrf
                        <div class="form-group">
                          <label for="recipient-name" class="col-form-label">اسم صاحب الفاتورة:</label>
                          <select name="user_id" required class=" select2 " id="">
                            <option value="" selected >اختر صاحب الفاتورة</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">نوع الفاتورة   :</label>
                            <select name="peroid" required class=" form-control " id="">
                              <option value="" selected >اختر نوع الفاتورة </option>
                             <option value="1">شهرية</option>
                             <option value="12">سنوية</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">تاريخ الفاتورة    :</label>
                            <input type="date" name="start_at" required class="form-control" id="">
                          </div>
                        <div class="form-group">

                            <input type="submit" value="ارسال" class="btn btn-info">
                        </div>
                      </form>
                    </div>
                  
                  </div>
                </div>
              </div>

        </div>

    </div>
@endsection
@section('script')

@endsection
