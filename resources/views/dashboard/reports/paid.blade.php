@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> الاعضاء ذو الاشتراكات الفعالة  </h4>
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
                              
                            </div>

                            <div class="card-content collapse show">

                                <div class="card-body card-dashboard">
                                    @include('dashboard.parts._error')
                                    @include('dashboard.parts._success')

                                    <br>

                                    <br>
                                    <form method="GET">
                                        <select name="filter">
                                            <option value="all" @if ($request->filter == 'all') selected @endif>All
                                            </option>
                                            <option value="today" @if ($request->filter == 'today') selected @endif>Today
                                            </option>
                                            <option value="yesterday" @if ($request->filter == 'yesterday') selected @endif>
                                                Yesterday</option>
                                            <option value="this_week" @if ($request->filter == 'this_week') selected @endif>This
                                                Week</option>
                                            <option value="this_month" @if ($request->filter == 'this_month') selected @endif>
                                                This Month</option>
                                        </select>

                                        <input type="date" value="{{ $request->from_date }}" name="from_date">
                                        <input type="date" value="{{ $request->to_date }}" name="to_date">

                                        <button type="submit">Filter</button>
                                    </form>
                                    <table class="table table-striped table-bordered zero-configuration table_calss"
                                    id="storestable"
                                    style=" max-width: 100px;
                                white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;">

                                        <br>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم </th>
                                                <th>الدولة </th>
                                                <th>رقم الهاتف </th>
                                                <th>نوع الباقة</th>
                                                <th>تاريخ البدء</th>
                                                <th>تاريخ الانتهاء</th>

                                                <th>تاريخ التسجيل</th>

                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($users as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>


                                                <td>{{ $item->name }} </td>
                                                <td>{{ $item->phone != null ? getCountryFromPhoneNumber($item->phone) : '_' }}
                                                </td>
                                                <td>{{ $item->phone != null ? $item->phone : '_' }} </td>
                                                <td>{{ @$item->subscription->last()->package->title }}</td>
                                                <td>{{ $item->subscription->last()->start_at }}</td>
                                                <td>{{ $item->subscription->last()->end_at }}</td>

                                                <td>{{ $item->created_at->format('Y-m-d') }} </td>




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
