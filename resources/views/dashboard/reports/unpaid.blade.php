@extends('layouts.backend')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> الاعضاء غير الدافعين </h4>
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
                                    <table class="table table-striped table-bordered zero-configuration" id="storestable">


                                        <br>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم </th>
                                                <th>الدولة </th>
                                                <th>رقم الهاتف </th>
                                                <th>الحالة </th>
                                                <th>is expired </th>

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
                                                    <td>
                                                        <select class="status-select btn btn-info" @if($item->call_cender_status != 'Pending') disabled @endif  data-user-id="{{ $item->id }}">
                                                            <option value="Pending" @if($item->call_cender_status == 'Pending' ) selected @endif>Pending</option>
                                                            <option value="Interested" @if($item->call_cender_status == 'Interested' ) selected @endif>Interested</option>
                                                            <option value="Negotiated" @if($item->call_cender_status == 'Negotiated' ) selected @endif>Negotiated</option>
                                                            <option value="NotInterested" @if($item->call_cender_status == 'NotInterested' ) selected @endif>Not interested</option>
                                                            <option value="NoAnswer" @if($item->call_cender_status == 'NoAnswer' ) selected @endif>No answer</option>
                                                        </select>
                                                    </td>
                                                    <th>{{ $item->is_finish ==1  ? 'منتهي الاشتراك' : "_"}}</th>
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
    <div class="modal fade" id="interested-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> تغير الحالة </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="interested-modal-content">
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="Negotiated-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> تغير الحالة </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="Negotiated-modal-content">
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(".status-select").on("change", function() {
                var selectedValue = $(this).val();
                var userId = $(this).data("user-id");

                if (selectedValue === "Interested") {
                    openModalForInterested(selectedValue, userId)
                } else if (selectedValue === "Negotiated") {
                    openModalForNegotiated(selectedValue, userId)
                    // Use userId to send along with the AJAX request
                }else if (selectedValue === "NotInterested") {
                    openModalForNegotiated(selectedValue, userId)
                    // Use userId to send along with the AJAX request
                }else if (selectedValue === "NoAnswer") {
                    send_data_not_answer(selectedValue, userId)
                    // Use userId to send along with the AJAX request
                }
                
                
                // Handle other cases similarly
            });

            function openModalForInterested(selectedValue, userId) {
                $.ajax({
                    url: "{{ route('get_interested_modal') }}",
                    method: "GET",
                    data: {
                        user_id: userId,
                        selected_value: selectedValue
                    },
                    success: function(response) {
                        $("#interested-modal-content").html(response);
                        $("#interested-choosevalue-input").val(selectedValue); // Set the input value
                        $("#interested-modal").modal("show");
                    }
                });
            }
            function openModalForNegotiated (selectedValue, userId) {
                $.ajax({
                    url: "{{ route('get_negotiated_modal') }}",
                    method: "GET",
                    data: {
                        user_id: userId,
                        selected_value: selectedValue
                    },
                    success: function(response) {
                        $("#Negotiated-modal-content").html(response);
                        $("#interested-choosevalue-input").val(selectedValue); // Set the input value
                        $("#Negotiated-modal").modal("show");
                    }
                });
            }
            function send_data_not_answer (selectedValue, userId) {
                $.ajax({
                    url: "{{ route('send_data_not_answer') }}",
                    method: "GET",
                    data: {
                        user_id: userId,
                        status: selectedValue
                    },
                    success: function(response) {
                        $('select[data-user-id='+userId+']').prop('disabled', true);


                    Swal.fire({
                        icon: 'success',
                        title: 'تم تغير الحالة بنجاح',
                    })  
                    }
                });
            }

        });
    </script>
@endsection
