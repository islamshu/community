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
                          
                                @can('create-invoice')
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">انشاء فاتورة جديدة</button>
                                @endcan
                                <div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <select name="user_id" required  class="select2 form-control">
                                              <option value="" selected >اختر صاحب الفاتورة</option>
                                              @foreach ($users as $item)
                                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group">
                                              <label for="recipient-name" class="col-form-label">نوع الباقة   :</label>
                                              <select name="peroid" required class=" form-control " id="peroid">
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
                                              <label for="recipient-name" class="col-form-label">كود الخصم     :</label>
                                              <input type="text" name="discount_code"   class="form-control"  id="discount_code">
                                            </div>
                                            <div class="form-group">
                                              <label for="recipient-name" class="col-form-label">السعر     :</label>
                                              <input type="text" name="price" readonly required class="form-control"  id="invoice_price">
                                            </div>
                                            
                                            <div class="form-group">
                                              <label for="recipient-name" class="col-form-label">السعر بعد الخصم     :</label>
                                              <input type="text" name="price_after_discount" readonly required class="form-control" id="invoice_after_price">
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
                                                <th>البريد الاكتروني لصاحب الفاتورة   </th>
                                                <th>نشط مجاني بواسطة</th>

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
                                                    <td>{{ $item->user->email }} </td>
                                                    <td>{{ @$item->updater->name ?? '_' }}</td>

                                                    <td>
                                                      @can('read-invoice')

                                                        <a href="{{ route('invoideviewPdf',$item->code) }}" target="_blank">PDF</a>
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
