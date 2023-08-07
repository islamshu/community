@extends('layouts.backend')
@section('css')
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css">
    <style>
        .activeimage {
            border-radius: 3% !important;
            border: 5px solid #d2cece !important;
        }

        .fileInput1 {
            border: var(--darkColor) 2px solid;
            padding: 6px;
            background-color: transparent;
            color: var(--darkColor);
            margin-left: 10px;
            font-weight: 600;
            margin-top: 5px;
        }

        .modal-dialog {
            max-width: 1200px;
        }

        .modal {}

        .modal .head {}

        .modal .head form {
            display: flex;
            justify-content: space-between;
        }

        .modal form .selects {
            display: flex;
        }

        .modal .main-content {
            height: 540px;
            width: 75%;
            overflow-y: scroll;
            overflow-x: hidden;
            margin: 10px;
        }

        .modal .img-info {
            width: 25% !important;
            padding: 10px;
            margin: 10px;
            padding-top: 20px;
            background-color: #f6f6f6;
        }

        .modal .main-content .item {
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
            /* padding: 10px; */
            border-radius: 5px;
            margin: 10px;
            text-align: right;
            overflow: hidden;
            width: 100%;
            height: 208px;
            cursor: pointer;
        }

        .modal .main-content .item .img-box {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .modal .main-content .item .img-box img {
            width: 100%;
            height: 100%;
        }

        .modal .main-content .item p {
            margin-bottom: 5px;
            font-size: 16px;
            font-weight: 600;
        }

        .modal .main-content .item span {
            font-size: 12px;
        }

        .modal-footer {
            justify-content: space-between;
        }

        .modal-header .btn-close {
            margin: 0;
        }

        .btn-close:focus {
            box-shadow: none;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .img-preview {
            width: 150px;
            height: 150px;
            display: block;
            margin: auto;
            margin-top: 30px;
        }

        .bootstrap-tagsinput .tag {
            color: #2b47da !important;
            margin: 1px !important;
            background: #eae6e6 !important;
            border-radius: 6px !important;
            padding: 2px !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> {{ $blog['title'] }}   </h4>
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

                                
                                    <div class="row">

                                        <div class="form-group col-md-6">
                                            
                                            <div class="form-group">
                                                <img src="{{ $blog['image'] }}" id="src_image" style="width: 300px"
                                                    class="img-thumbnail " alt="">
                                            </div>
                                            <input type="hidden" value="" disabled name="image_id" id="image_idd">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <br><label> عنوان المقال :</label>

                                            <input type="text" id="title_ar" value="{{ $blog['title'] }}" disabled name="title_ar" required
                                                class="form-control form-control-solid" placeholder="العنوان بالعربية" />

                                        </div>


                                        <div class="form-group col-md-6">

                                            <br><label> الوصف :</label>
                                            <textarea disabled name="description_ar" class="ckeditor" rows="4" cols="50">{{ $blog['description'] }}</textarea>

                                        </div>
                                        <div class="form-group col-md-6">

                                            <br><label> وصف مصغر :</label>
                                            <textarea disabled name="small_description" class="ckeditor form-control">{{ $blog['meta_description'] }}</textarea>

                                        </div>
                                        
                                       
{{-- 
                                        <div class="form-group col-md-6">

                                            <br> <label>الوسوم  :</label>
                                            <input type="text"
                                            required disabled name="tags"
                                                placeholder="اضف الوسوم " value="{{ $tags }}"
                                                data-role="tagsinput" class="form-control form-control-solid" />


                                        </div> --}}
                                    </div>



                                        <br>
                                       
                                </form>


                                    {{-- @include('dashboard.blogs.upload_image') --}}
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
    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script>
        var token = "{{ csrf_token() }}";
    </script>
    <script>
        function myImage(id) {
            var imagee = '.item' + id;
            $(".img-info").css("display", "block");
            const boxes = document.querySelectorAll('.imges');

            boxes.forEach(box => {
                // ✅ Remove class from each element
                box.classList.remove('activeimage');

                // ✅ Add class to each element
                // box.classList.add('small');
            });
            $(imagee).addClass("activeimage");



            var url = '{{ route('get_image', ':id') }}';
            get_url = url.replace(':id', id);
            $.ajax({
                url: get_url,
                type: 'get',
                success: function(data) {
                    $('#alt_image').val(data.alt);
                    $('#title_image').val(data.title);
                    $('#description_image').val(data.description);
                    $('#image_id_info').val(data.id);


                }
            });
        }

        function storedata_image() {
            var image_id = $('#image_id_info').val();
            var title_image = $('#title_image').val();
            var description_image = $('#description_image').val();
            var alt_image = $('#alt_image').val();


            $.ajax({
                url: "{{ route('update_data_image') }}",
                type: 'post',
                data: {
                    '_token': token,
                    "image_id": image_id,
                    "title_image": title_image,
                    "description_image": description_image,
                    "alt_image": alt_image
                },


                success: function(data) {

                    swal(
                        '',
                        'Updated successfully',
                        'success'
                    )


                },
                error: function(data) {
                    alert('error');
                },
            });

        }

        function saveimage(id) {
            var url = '{{ route('get_image', ':id') }}';
            get_url = url.replace(':id', id);
            $.ajax({
                url: get_url,
                type: 'get',
                success: function(data) {
                    $('#image_idd').val(data.id)
                    var url = '{{ asset('/') }}';
                    var src1 = url + `uploads/` + data.image;
                    $('#src_image').attr("src", src1);
                    $('#exampleModaldd').modal('toggle');
                }
            });
        }

        function myFunction() {
            var frm = $('#uploadimage_modal');
            var formData = new FormData(frm[0]);
            formData.append('image', $('#imageuploadmodal')[0].files[0]);
            formData.append('_token', token);

            $.ajax({
                url: "{{ route('upload_image') }}",
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,

                success: function(data) {
                    var url_image = '{{ asset('/') }}';
                    var text = `<div class="col-md-3 blogsimage" >
                                    <div class="item` + data.id + ` item ">
                                        <div class="img-box">
                                            <img src="` + url_image + `uploads/` + data.image +
                        `" ondblclick="saveimage(` + data
                        .id + `)"  onclick="myImage(` + data
                        .id + `)" width="150" height="150" alt="" />
                                        </div>
                                    </div>
                                </div>`;
                    $(".blogsimage").prepend(text);

                    // var table = $('#stores').DataTable();



                    // document.getElementById(fromname).reset();
                    swal(
                        '',
                        'Added successfully',
                        'success'
                    )


                },
                error: function(data) {
                    alert('error');
                },
            });





        }
    </script>
@endsection
