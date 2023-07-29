
<div class="form-body">
    
    <div class="row">
        <div class="col-md-6 mt-2">
            <label>الاسم  </label>
            <input  readonly type="string" value="{{ $user->name}}" name="name" class="form-control" required >
        </div>
        <div class="col-md-6 mt-2">
            <label>البريد الاكتروني  </label>
            <input  readonly type="email" value="{{ $user->email }}" name="email" class="form-control" required >
        </div>
        <br>
        <div class="col-md-6 mt-2">
            <label> رقم الهاتف  </label>
            <input  readonly type="text" name="phone" value="{{ $user->phone }}" class="form-control" required >
        </div>
        <br>
    
    </div>
    <div class="row">
        <div class="col-md-6 mt-2">
            <label>الباقة</label>
            <select name="packege_id" class="form-control" disabled required id="packege_id">
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
            <input  readonly type="url" name="site_url" value="{{ $user->site_url }}" id="site_url" class="form-control"  >
        </div>
       
        <div class="col-md-6">
            @if(@$user->domains != null)
            <label> مجالات المستخدم  </label>
            <select class="select2-placeholder form-control" id="date_member" 
                name="domains[]" disabled multiple id="single-placeholder">
            <option value="">يرجى الاختيار</option>
            @foreach ($domains as $item)
                <option value="{{ $item->id }}" @if(in_array($item->id,json_decode($user->domains))) selected @endif>{{ $item->title }}</option>
            @endforeach

            </select>
            @endif
        </div>
    {{-- <div class="row">
        
        
    </div> --}}
</div>
<div class="row">
    @foreach ($user->answer as $item)
        
   
    <div class="col-md-6 mt-2">
        <label>  السؤال </label>
        <input  readonly type="email" value="{{ $item->question }}" name="email" class="form-control" required >
    </div>
    <br>
    <div class="col-md-6 mt-2">
        <label>الاجابة</label>
        <input  readonly type="text" name="phone" value="{{ $item->answer }}" class="form-control" required >
    </div>
    @endforeach
   
</div>

