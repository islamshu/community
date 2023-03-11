@extends('layouts.backend')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> تعديل عضو   </h4>
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
                                    action="{{ route('users.update',$user->id) }}" enctype="multipart/form-data">
                                    @csrf 
                                    @method('put')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label>الصورة</label>
                                                <input type="file" name="image" class="form-control image"  >
                                                <div class="form-group">
                                                    <img src="{{ asset('uploads/'.$user->image) }}" style="width: 100px"
                                                        class="img-thumbnail image-preview" alt="">
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label>الاسم  </label>
                                                <input type="string" value="{{ $user->name }}" name="name" class="form-control" required >
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>البريد الاكتروني  </label>
                                                <input type="email" value="{{ $user->email}}" name="email" class="form-control" required >
                                            </div>
                                            <br>
                                            <div class="col-md-6 mt-2">
                                                <label> رقم الهاتف  </label>
                                                <input type="text" name="phone" value="{{ $user->phone }}" class="form-control" required >
                                            </div>
                                            <br>
                                            <div class="col-md-6 mt-2">
                                                <label>كلمة المرور   </label>
                                                <input type="password" name="password" class="form-control"  >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label>الباقة</label>
                                                <select name="packege_id" class="form-control" required id="packege_id">
                                                    <option value="" selected disabled>اختر</option>
                                                    @foreach (App\Models\Package::get() as $item)
                                                    <option value="{{ $item->id }}" @if($user->packege_id == $item->id ) selected @endif>{{ $item->title }}</option>    
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                            <br>
                                            <div class="col-md-6 mt-2">
                                                <label>حالة الدفع</label>
                                                <select name="is_paid" class="form-control" required >
                                                    <option value="" selected disabled>اختر</option>
                                                    <option value="1" @if($user->is_paid == 1 ) selected @endif>مدفوع</option>
                                                    <option value="0" @if($user->is_paid == 0 ) selected @endif>غير مدفوع</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>هل يملك موقع الكتروني    </label>
                                                <select name="have_website" class="form-control" required id="have_website">
                                                    <option value="" selected disabled>اختر</option>
                                                    <option value="1" @if($user->have_website == 1 ) selected @endif>نعم</option>
                                                    <option value="0" @if($user->have_website == 0 ) selected @endif>لا</option>
                                                </select>
                                            </div>
                                            <br>
                                            <div class="col-md-6 mt-2 site_url" @if($user->have_website != 1 ) selected  style="display: none" @endif >
                                                <label>رابط الموقع    </label>
                                                <input type="url" name="site_url" value="{{ $user->site_url }}" id="site_url" class="form-control"  >
                                            </div>
                                            <div class="col-md-8">
                                                <label>مجالات المستخدم  </label>
                                                <textarea name="domains" required class="form-control" id="" cols="30" rows="10">{{ $user->domains }}</textarea>
                                            </div>
                                           
                                        {{-- <div class="row">
                                            <div class="col-md-8">
                                                <label>الوصف  </label>
                                                <textarea name="description" required class="form-control" id="" cols="30" rows="10"></textarea>
                                            </div>
                                            
                                        </div> --}}
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
        $('#have_website').change(function(){
           let v =  $(this).val();
           if(v == 1){
            $('.site_url').css('display','block');
            $('#site_url').prop('required',true);
           }else{
            $('.site_url').css('display','none');
            $('#site_url').prop('required',false);
           }
        })
    </script>
@endsection
