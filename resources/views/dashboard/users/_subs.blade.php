<table class="table table-striped table-bordered zero-configuration" id="storestable">


    <br>
    <thead>
        <tr>
            <th>#</th>
            <th>الباقة </th>
            <th> تاريخ الدفع   </th>
            <th> تبدا في    </th>
            <th> تنتهي في    </th>

        </tr>
    </thead>
    <tbody id="stores">
        @foreach ($subs as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    
                    {{ $item->packege->title }}                    
                </td>
                <td>{{ $item->title }} </td>

                <td>
                    <a href="{{ route('tools.edit',$item->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i>  </a>

                    <form style="display: inline"
                        action="{{ route('tools.destroy', $item->id) }}"
                        method="post">
                        @method('delete') @csrf
                        <button type="submit" class="btn btn-danger delete-confirm"><i
                                class="fa fa-trash"></i></button>
                    </form>
                </td>



            </tr>
        @endforeach

    </tbody>

</table>