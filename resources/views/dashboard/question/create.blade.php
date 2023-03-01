@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> انشاء سؤال جديد   </h4>
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
                                <form id="edit_form_new" method="post" action="{{ route('quastions.store') }}" style="direction: rtl">
                                    @csrf
                                
                                    
                                    <div class="row">
                                        
                                        <div class="form-group col-md-8">
                                            <label for="email"> السؤال : <span class="required"></span></label>
                                            <input type="text" name="title" required class="form-control"
                                                value="{{ old('title')}}" id="title">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email"> نوع الاجبة  : <span class="required"></span></label>
                                            <select name="type" class="form-control" id="answer_question">
                                                <option value="" selected disabled>اختيار  </option>
                                                <option value="single">اختيار خيار واحد</option>
                                                <option value="multi">اختيار عدة خيارات </option>
                                                <option value="text">كتابة نص   </option>

                                            </select>
                                        </div>
                                    </div>
                                        <div id="car_parent">
                    
                    
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label>الاجابة  :</label>
                                                            <input type="text"
                                                                class="form-control form-control-solid form-control-lg name_ar_offer "
                                                                id="name_ar_offer" required name="addmore[0][answer]"  />
                    
                                                        </div>
                                                    </div>
                                                    <!--end::Input-->
                                                    <!--begin::Input-->
                                                   
                                                </div>
                    
                    
                    
                    
                    
                                            </div>
                    
                                            <div id="extra">
                    
                    
                    
                    
                    
                                            </div>
                                            <br>
                                            <button type="button" name="add"
                                                class="btn btn-success add_row for-more">{{ __('اضف المزيد من الخيارات') }}</button>
                    
                    
                                           
                                        </div>
                    
                                
                                
                                
                                
                                
                                
                                    <br>
                                
                                
                                    <button class="btn btn-info" type="submit">حفظ</i></button>
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
    $(document).ready(function() {
        $('#answer_question').change(function(){
            alert('dd');
        }); 
        var i = 1;
        $('.add_row').on('click', function() {
            addRow();
        });

        function addRow() {
            ++i;
            const sum = i + 1;



            let form = `
                <span class="test">
                <div class="card-body" >
                    <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>الاجابة :</label>
                            <input type="text"
                                class="form-control form-control-solid form-control-lg name_ar_offer"
                                id="name_ar_offer" name="addmore[` + i + `][answer]" required
                                />
                            
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <button type="button" class="remove_button btn btn-danger " style="margin-top:3%" title="Remove field">حذف</button>

                        </div>


                    
                </div>



                </div>
                </span>
                `;
            $('#extra').append(form);
            var wrapper = $('#extra');
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').parent('div').parent('div').remove();

            });

            // $(wrapper1).on('click', '.remove_button_old', function (e) {
            //     alert('d');
            //         e.preventDefault();
            // $(this).parent('span').remove();

            // });
        }
        var wrapper1 = $('#partent');
        $(wrapper1).on('click', '.remove_button_old', function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove();
        });
    });
</script>
@endsection
