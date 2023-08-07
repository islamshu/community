@foreach ($images as $item)
    <div class="col-md-3  " >
        <div class="item{{ $item->id }} item  imges">
            <div class="img-box">
                <img src="{{ asset('uploads/' . $item->image) }}" ondblclick="saveimage({{ $item->id }})" onclick="myImage({{ $item->id }})" width="150" height="150" alt="" />
            </div>
        </div>
    </div>
@endforeach
