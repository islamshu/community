@extends('layouts.backend')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> المطالبات  </h4>
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
                                @can('create-claim')
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">انشاء مطالبة جديدة</button>
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
                                                <th>تاريخ المطالبة   </th>
                                                <th>اسم صاحب المطالبة   </th>
                                                <th>البريد الاكتروني لصاحب المطالبة   </th>
                                                <th>طريقة الدفع      </th>
                                                <th>رابط الدفع</th>
                                                <th>الاجراءات</th>


                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($claims as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                
                                                    <td>{{ $item->created_at }} </td>
                                                    <td> <a href="{{ route('users.show',$item->user->id) }}" target="_blank">{{ $item->user->name }}</a> </td>
                                                    <td>{{ $item->user->email }} </td>
                                                    <td>{{ $item->payment_method }}</td>
                                                    <th><a href="{{ $item->paid_url }}" class="btn btn-info"><i class="fa fa-eye"></i></a></th>
                                                    <th>
                                                      {{-- <a href="{{ route('viewmail_claim',$item->id) }}" class="btn btn-success"><i class="fa fa-print"></i></a> --}}

                                                      <a href="{{ route('viewPdf_claim',$item->id) }}" class="btn btn-success"><i class="fa fa-print"></i></a>
                                                      <a href="{{ route('resend_mail',$item->id) }}" class="btn btn-info">اعادة الارسال</a>
                                                      @can('destroy-claim')
                                                        
                                                      <form style="display: inline"
                                                            action="{{ route('claims.destroy', $item->id) }}"
                                                            method="post">
                                                            @method('delete') @csrf
                                                            <button type="submit" class="btn btn-danger delete-confirm"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                        @endcan

                                                    </th>
                                                   



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
            <div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  " role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"> انشاء مطالبة</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="{{ route('claims.store') }}">
                        @csrf
                        <div class="form-group">
                          <label for="recipient-name" class="col-form-label">اسم صاحب الفاتورة:</label>
                          <select name="user_id" required id="mySelect">
                            <option value="" selected >اختر صاحب الفاتورة</option>
                            @foreach ($users as $item)
                               <option value="{{ $item->id }}">{{$item->name  }} / {{ $item->email }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">نوع الباقة   :</label>
                            <select name="package_id" required class=" form-control ">
                              <option value="" selected >اختر نوع الباقة </option>
                              @foreach (App\Models\Package::get() as $item)
                              <option value="{{ $item->id }}"  > {{ $item->title }}  </option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">تاريخ الاشتراك    :</label>
                            <input type="date" name="start_at" required class="form-control" id="start_at">
                          </div>
                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">طريقة الدفع    :</label>
                            <select name="payment_method" required class=" form-control " >
                              <option value="" selected >  نوع الدفع  </option>
                              <option value="visa">Visa</option>
                              <option value="paypal">Paypal</option>
                              <option value="stripe">Stripe</option>
                            </select>
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
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
   $(document).ready(function() {
      $('#mySelect').select2();
    });
</script>
    <script>
      $( "#peroid" ).on( "change", function() {
        var packge_id= $(this).val();
        $('#discount_code').val('');
        $.ajax({
            type: "GET",
            url: "{{ route('get_price_for_packge') }}",
            data:{'packge_id':packge_id},
            async: false,
            success: function(response) {
              $('#invoice_price').val(response.price);
              $('#invoice_after_price').val(response.price);
            }
        });
      } );

      $( "#discount_code" ).on( "change", function() {
        var packge_id= $("#peroid").val();
        var discount_code= $('#discount_code').val();
        var start_at = $('#start_at').val();
        if(start_at == ''){
          alert('يرجى اضافة تاريخ الاشتراك');
          return false;
        }
        $.ajax({
            type: "GET",
            url: "{{ route('get_discount_code') }}",
            data:{'discount_code':discount_code,'packge_id':packge_id,'start_at':start_at},
            async: false,
            success: function(response) {
              if(response.success == true){
              $('#invoice_after_price').val(response.price);
            }else{
              $('#invoice_after_price').val(response.price);
              $('#discount_code').val('');
              alert(response.message);
            }
        }
      });
        
      } );

      
    </script>
@endsection
