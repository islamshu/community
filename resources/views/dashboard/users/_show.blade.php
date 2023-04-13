
<div class="form-body">
    <div class="row">
        <div class="col-md-6 mt-2">
            <label>الصورة</label>
            <div class="form-group">
                <img src="{{ asset('uploads/'.$user->image) }}" style="width: 100px"
                    class="img-thumbnail image-preview" alt="">
            </div>
        </div>
       
    </div>
    <div class="row">
        <div class="col-md-6 mt-2">
            <label>الاسم  </label>
            <input  readonlytype="string" value="{{ $user->name}}" name="name" class="form-control" required >
        </div>
        <div class="col-md-6 mt-2">
            <label>البريد الاكتروني  </label>
            <input  readonlytype="email" value="{{ $user->email }}" name="email" class="form-control" required >
        </div>
        <br>
        <div class="col-md-6 mt-2">
            <label> رقم الهاتف  </label>
            <input  readonlytype="text" name="phone" value="{{ $user->phone }}" class="form-control" required >
        </div>
        <br>
    
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
            <label>هل يملك موقع الكتروني    </label>
            <select name="have_website" class="form-control" required id="have_website">
                <option value="" selected disabled>اختر</option>
                <option value="1" @if($user->have_website == 1 ) selected @endif>نعم</option>
                <option value="0" @if($user->have_website== 0 ) selected @endif>لا</option>
            </select>
        </div>
        <br>
        <div class="col-md-6 mt-2 site_url" @if($user->have_website != 1 ) selected  style="display: none" @endif >
            <label>رابط الموقع    </label>
            <input  readonlytype="url" name="site_url" value="{{ $user->site_url }}" id="site_url" class="form-control"  >
        </div>
       
        <div class="col-md-6">
            <label>مجالات المستخدم  </label>
            <textarea name="domains" required class="form-control" id="" cols="30" rows="2">{{ $user->domains }}</textarea>
        </div>
    {{-- <div class="row">
        
        
    </div> --}}
</div>
<div class="row">
    @foreach ($user->answer as $item)
        
   
    <div class="col-md-6 mt-2">
        <label>  السؤال </label>
        <input  readonlytype="email" value="{{ $item->question }}" name="email" class="form-control" required >
    </div>
    <br>
    <div class="col-md-6 mt-2">
        <label>الاجابة</label>
        <input  readonlytype="text" name="phone" value="{{ $item->answer }}" class="form-control" required >
    </div>
    @endforeach
   
</div>