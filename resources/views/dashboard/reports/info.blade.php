<div class="modal-body">
    <form >
        @csrf
        <label for="">الحالة</label>
        <input type="text" name="status" required id="interested-choosevalue-input" class="form-control" readonly
            value="{{ $user->call_cender_status }}" />
        <br>
        @if($user->call_cender_status == 'Interested')
        <label for="">الموعد القادم</label>
        <input type="date" name="calendar" value="{{ $user->calender }}" readonly class="form-control" id="">
        @endif
        <br>
        @if($user->call_cender_status != 'Pending' && $user->call_cender_status != 'NoAnswer')
        <label for="">التفاصيل</label>
        <input type="text" name="extra_input" value="{{ $user->extra_input }}" readonly class="form-control" id="">
        @endif
        <br>
        <!-- Other form elements like calendar and input -->
    </form>
</div>