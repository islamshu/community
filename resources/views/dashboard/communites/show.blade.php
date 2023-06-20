@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> تعديل مجتمع </h4>
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

                                <form enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>الصورة</label>
                                                <img src="{{ asset('uploads/' . $community->image) }}" style="width: 100px"
                                                    class="img-thumbnail image-preview" alt="">
                                            </div>
                                            <div class="col-md-6">
                                                <label>العنوان </label>
                                                <input type="string" disabled value="{{ $community->title }}"
                                                    name="title" class="form-control" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-6 mt-2">
                                            <label>تاريخ الجلسة</label>
                                            {{-- {{ dd(now() , get_general_value('meeting_date')) }} --}}
                                            <input type="datetime-local" disabled class="form-control"
                                                value="{{ $community->meeting_date }}" name="meeting_date" id="">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label>مدة الجلسة بالدقائق </label>
                                            <input type="number" disabled class="form-control"
                                                value="{{ $community->meeting_time }}" name="meeting_time" id="">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label>مدة دورة التكرار </label>
                                            <input type="number" disabled class="form-control"
                                                value="{{ $community->peroid_number }}" name="peroid_number" id="">
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>رابط الاجتماع</label>
                                            <input type="text" id="copyInput" disabled class="form-control"
                                                value="{{ $community->meeting_url }}" name="peroid_number" id="">
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <a class="btn btn-primary" id="copyButton"><i class="fa fa-copy"></i></a>

                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label>نوع مدة التكرار </label>
                                            <select disabled name="peroid_type" class="form-control" id="">
                                                <option value="" disabled>اختر نوع التكرار</option>
                                                <option value="day" @if ($community->peroid_type == 'day') selected @endif>يوم
                                                </option>
                                                <option value="week" @if ($community->peroid_type == 'week') selected @endif>
                                                    اسبوع</option>
                                                <option value="month" @if ($community->peroid_type == 'month') selected @endif>شهر
                                                </option>
                                            </select>

                                        </div>


                                    </div>

                                    <br>

                            </div>





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
    <script>
        $(document).ready(function() {
  $('#copyButton').click(function() {
    var copyText = document.getElementById('copyInput');

    // Create a range to select the text
    var range = document.createRange();
    range.selectNode(copyText);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);

    // Copy the selected text
    document.execCommand('copy');

    // Optionally, provide visual feedback or show a success message
    alert('Text copied!');
  });
});

    </script>
@endsection
