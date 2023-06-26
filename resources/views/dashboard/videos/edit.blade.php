@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> تعديل الجلسة     </h4>
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
    
                                <form class="form" method="post"
                                    action="{{ route('videos.update',$video->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>صورة الجلسة</label>
                                                <input type="file" name="image" class="form-control image"  >
                                                <div class="form-group">
                                                    <img src="{{ asset('uploads/'.$video->images) }}" style="width: 100px"
                                                        class="img-thumbnail image-preview" alt="">
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>عنوان الجلسة  </label>
                                                <input type="string" value="{{ $video->title }}" name="title" class="form-control" required >
                                            </div>
                                            <div class="col-md-6">
                                                <label>تاريخ الجلسة  </label>
                                                <input type="datetime-local" value="{{ $video->date }}" name="date" id="date" class="form-control" required >
                                            </div>
                                         
                                            <div class="col-md-6">
                                                <label>عدد الاعضاء   </label>
                                                <input type="number" id="num_guest"  name="num_guest" value="{{ $video->num_guest }}" class="form-control" required >
                                            </div>
                                            <div class="col-md-6">
                                                <label>المجتمع</label>
                                               <select name="community_id" class="form-control" id="" required>
                                                <option value="" selected disabled> اختر المجتمع</option>
                                                @foreach ($communities as $item)
                                                    <option value="{{ $item->id }}" @if($video->community_id == $item->id) selected @endif >{{ $item->title }}/option>
                                                @endforeach
                                               </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label>جزء من الاعضاء    </label>
                                                <select class="select2-placeholder form-control" id="date_member" name="users[]" required multiple id="single-placeholder">
                                                    @foreach (App\Models\User::where('type','user')->get() as $item)
                                                    <option value="{{ $item->id }}" @if(in_array($item->id, $users)) selected @endif>{{ $item->name }}</option>
                                                    @endforeach
                                                 
                                                  </select>                                            
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>ملف او رابط  </label>
                                                <select name="type"  required class="form-control" id="video_type">
                                                    <option value="" selected disabled>اختر</option>
                                                    <option value="url" @if($video->type == 'url') selected @endif>رابط</option>
                                                    <option value="video" @if($video->type == 'video') selected @endif>ملف</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6" id="urlid" @if($video->type != 'url') style="display: none" @endif>
                                                <label>الرابط   </label>
                                                <input type="text" value="{{ $video->url }}" name="url" id="url"  class="form-control"  >
                                            </div>
                                            <div class="col-md-6" id="videofileid"  @if($video->type != 'video') style="display: none" @endif>
                                                <label>ارفع الفيديو </label>
                                                <input type="file" name="video"  id="videofile" class="form-control image"  >
                                                <div class="form-group">
                                                    <br>
                                                    <a href="{{ asset('uploads/'.$video->file) }}" class="btn btn-info" target="_blank"> مشاهدة الملف</a>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>الوصف  </label>
                                                <textarea name="description" required class="form-control ckeditor" id="" cols="30" rows="10">{{ $video->description }}</textarea>
                                            </div>
                                            
                                        </div>
                                    
                                        <br>
                                        
                                        <br>
                                      
                                       
                                        <br>
                                        
                                       
                                    </div>
                                   
    
    
                                    <div class="form-actions left">

                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> @lang('حفظ')
                                    </button>
                                        </button>
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
        $( "#video_type" ).change(function() {
            var tt =  $(this).val();
            if(tt =='url'){
                $("#urlid").css("display", "block");
                $("#videofileid").css("display", "none");
                $("#url").prop('required',true);
                $('#videofile').val('');
                $("#videofile").prop('required',false);

            }else if(tt =='video'){
                $("#videofileid").css("display", "block");
                $("#urlid").css("display", "none");
                $("#videofile").prop('required',true);
                $('#url').val('');
                $("#url").prop('required',false);

            }
  
        });
        $('#date').change(function() {
            var datee = $(this).val();
            $.ajax({
                url: "{{ route('get_user_video') }}",
                type: 'post',
                data: {
                    'date': datee
                },
                dataType: 'json',
                success: function(data) {
                    $('#num_guest').val(data);
                },
                error: function(xhr, status, error) {
                    // Handle error
                }
            });
        });
    </script>
@endsection
