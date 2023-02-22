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

                                <form method="post" action="{{ route('tools.update', $tool->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row">

                                        <div class="form-group col-md-6">

                                            <br><label> عنوان الادة :</label>

                                            <input type="text" id="title" name="title" value="{{ $tool->title }}"
                                                required class="form-control form-control-solid"
                                                placeholder="العنوان الاداة" />

                                        </div>

                                        <div class="form-group col-md-8">

                                            <br><label> الوصف :</label>
                                            <textarea name="description" required class="form-control" id="">{{ $tool->description }}</textarea>

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
                                                @foreach ($tool->links as $key => $it)
                                                    <tr>
                                                        <td><input type="text" value="{{ $it->url }}" required
                                                                name="moreFields[{{ $key }}][url]"
                                                                placeholder="اضف الرابط" class="form-control" /></td>
                                                        <td>

                                                            <select name="moreFields[{{ $key }}][type]" required
                                                                class="form-control">
                                                                <option value="apple"
                                                                    @if ($it->type == 'apple') selected @endif>Apple
                                                                </option>
                                                                <option value="google"
                                                                    @if ($it->type == 'google') selected @endif>Google
                                                                </option>
                                                                <option value="url"
                                                                    @if ($it->type == 'url') selected @endif>Url
                                                                </option>
                                                                <option value="AppGallery"
                                                                    @if ($it->type == 'AppGallery') selected @endif>
                                                                    AppGallery </option>

                                                            </select>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-danger remove-tr">Remove</button>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td><input type="text"
                                                            name="moreFields[{{ $tool->links->count() + 1 }}][url]"
                                                            placeholder="اضف الرابط" class="form-control" /></td>
                                                    <td>
                                                        <select name="moreFields[{{ $tool->links->count() + 1 }}][type]"
                                                            class="form-control">
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
                                                    الخدمة <span class="required"></span></label>
                                                {{-- <input type="file" multiple id="imageupload" name="images[]" class="form-control"> --}}
                                                <input id="imagestore" class="form-control image" type="file"
                                                    name="image"><br />
                                                <div class="form-group">
                                                    <img src="{{ asset('uploads/' . $tool->image) }}" style="width: 100px"
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
        var d = {{ $count }};
        $("#add-btn").click(function() {
            ++d;

            $("#dynamicAddRemove").append('<tr><td><input required type="text" name="moreFields[' + d +
                '][url]" placeholder="أضف رابط" class="form-control" /></td><td><select required name="moreFields[' +
                d +
                '][type]" class="form-control"><option value="apple">Apple</option><option value="google">Google</option><option value="url">Url</option><option value="AppGallery">AppGallery</option></select></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
            );
        });
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
@endsection
