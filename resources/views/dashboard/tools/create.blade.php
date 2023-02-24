@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> انشاء كتاب جديد </h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @include('dashboard.parts._error')
                                @include('dashboard.parts._success')

                                <form method="post" action="{{ route('tools.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class=" col-md-6">

                                            <label> عنوان الاداة :</label>

                                            <input type="text" id="title" name="title" required
                                                class="form-control form-control-solid" placeholder="العنوان الاداة" />

                                        </div>
                                        <div class="col-md-6">
                                            <label>مجاني ام مدفوع  </label>
                                            <select name="type" id="type_price" required class="form-control" >
                                                <option value="" disabled selected>اختر</option>
                                                <option value="free">مجاني</option>
                                                <option value="unfree">مدفوع</option>

                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-md-6" id="pricecid" style="display: none">
                                            <label>السعر  </label>
                                            <input type="number" id="price" name="price" class="form-control"  >
                                        </div>

                                        <div class="form-group col-md-8">

                                            <br><label> الوصف :</label>
                                            <textarea name="description" name="description" required class="form-control" id=""></textarea>

                                        </div>

                                    </div>
                                    <div class="row">



                                        <div class="form-group col-md-6">

                                            <br> <label>روابط الاداة :</label>
                                            {{--   <input type="url" name="link" id="link"  class="form-control form-control-solid"
                                                placeholder="رابط الاداة" /> --}}
                                            <table class="table table-bordered" id="dynamicAddRemove">
                                                <tr>
                                                    <th>الرابط</th>
                                                    <th>النوع</th>
                                                    <th>Action</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" required name="moreFields[0][url]"
                                                            placeholder="اضف الرابط" class="form-control" /></td>
                                                    <td>
                                                        <select name="moreFields[0][type]" required class="form-control">
                                                            <option value="apple">Apple</option>
                                                            <option value="google">Google</option>
                                                            <option value="url">Url</option>
                                                            <option value="AppGallery">AppGallery</option>

                                                        </select>
                                                    <td>
                                                        <button type="button" name="add" id="add-btn"
                                                            class="btn btn-success">Add More</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">



                                        <div class=" col-md-6">
                                            <div class="form-group">
                                                <br> <label data-error="wrong" data-success="right" for="form3"> صور عن
                                                    الاداة <span class="required"></span></label>
                                                {{-- <input type="file" multiple id="imageupload" name="images[]" class="form-control"> --}}
                                                <input id="imagestore" class="form-control image" required type="file"
                                                    name="image"><br />
                                                    <div class="form-group">
                                                        <img src="" style="width: 100px"
                                                            class="img-thumbnail image-preview" alt="">
                                                    </div>


                                            </div>

                                        </div>


                                    </div>

                                    <br>
                                    <button class="btn btn-info" id="submitform" style="" type="submit">اضف جديد
                                        </i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </div>
    </section>

    </div>
@endsection
@section('script')
    <script type="text/javascript">
        var i = 0;
        $("#add-btn").click(function() {
            ++i;
            $("#dynamicAddRemove").append('<tr><td><input required type="text" name="moreFields[' + i +
                '][url]" placeholder="أضف رابط" class="form-control" /></td><td><select required name="moreFields[' +
                i +
                '][type]" class="form-control"><option value="apple">Apple</option><option value="google">Google</option><option value="url">Url</option><option value="AppGallery">AppGallery</option></select></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
                );
        });
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
        $('#type_price').change(function(){
        var typeprice = $(this).val();
        if(typeprice !='free'){
            $("#pricecid").css("display", "block");
            $("#price").prop('required',true);
            $("#price").val('');

        }else{
            $("#pricecid").css("display", "none");
            $("#price").prop('required',false); 
            $("#price").val('');

        }
    });
    </script>
@endsection

