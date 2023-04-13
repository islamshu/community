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
                    {{ $item->package->title }}                    
                </td>
                <td>
                    {{ $item->created_at->format('Y-m-d H:i:s') }}                    

                </td>
                <td>
                    {{ $item->start_at }}                    
                </td>
                <td>
                    
                    {{ $item->end_at }}                    
                </td>
               



            </tr>
        @endforeach

    </tbody>

</table>