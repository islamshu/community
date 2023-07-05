<table id="" class="example display" style="width:100%">
    <thead>
        <tr>
            <th>صورة المستخدم  </th>

            <th>اسم المستخدم  </th>
            <th>تاريخ اخر رسالة</th>

            <th>العمليات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $item)
        <tr>
            <td><img alt="Pic" src="{{ asset('public/uploads/' . $item->image) }}" width="50" height="50" ></td>

         <td>{{ $item->name }}</td>
         <td>{{ $item->created_at->format('Y-m-d') }}</td>

         <td>
            <a href="{{ route('show_message_from_user', [$item->id, $user]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
            
        </td>
        </tr>
            
        @endforeach
    </tfoot>
</table>