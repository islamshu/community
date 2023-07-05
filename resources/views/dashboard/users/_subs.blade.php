<table class="table table-striped table-bordered zero-configuration" id="storestable">


    <br>
    <thead>
        <tr>
            <th>#</th>
            <th>الباقة </th>
            <th> تاريخ الدفع   </th>
            <th> تبدا في    </th>
            <th> تنتهي في    </th>
            {{-- <th>طريقة الدفع</th> --}}
            {{-- <th>اضيف بواسطة </th> --}}


        </tr>
    </thead>
    <tbody id="stores">
        @foreach ($subs as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>   
                     @if($item->peroid == 1 ) اشتراك شهري @else اشتراك سنوي @endif                     
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
                {{-- <td>{{ $item->payment_method }}</td> --}}
                {{-- <td>{{ @$item->admin->name  == null ? 'دفع بنفسه' : $item->admin->name  }}</td> --}}




            </tr>
        @endforeach

    </tbody>

</table>