<table class="table table-striped table-bordered zero-configuration" id="storestable">


    <br>
    <thead>
        <tr>
            <th>#</th>
            <th>صورة صانع المحتوى</th>

            <th>اسم صانع المحتوى</th>
            <th>الحالة</th>
            <th>الاجراءات   </th>

        </tr>
    </thead>
    <tbody id="stores">
        @foreach ($regiect as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    
                    <img src="{{ asset('uploads/'.$item->user->image) }}" width="50" height="50" alt="">
                    
                </td>
                <td>{{ $item->user->name }} </td>
                <td>{{ get_status($item->status) }} </td>

                <td>

                    <a href="{{ route('users.show',$item->user->id) }}" ><button class="btn btn-success">مشاهدة  المستخدم</button>  </a>
                    <a href="{{ route('show_bank_info',$item->id) }}" ><button class="btn btn-primary">مشاهدة بيانات البنك </button>  </a>

                </td>



            </tr>
        @endforeach

    </tbody>

</table>