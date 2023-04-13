<table class="table table-striped table-bordered zero-configuration" id="storestable">


    <br>
    <thead>
        <tr>
            <th>#</th>
            <th>تاريخ الجلسة </th>
            <th> البريد الاكتروني </th>


        </tr>
    </thead>
    <tbody id="stores">
        @foreach ($vids as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>   
                    {{ $item->date }}                    
                </td>
                <td>   
                    {{ $item->email }}                    
                </td>
              
               



            </tr>
        @endforeach

    </tbody>

</table>