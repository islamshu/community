<div class="modal-body">
    <form id="interested-form">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user_id }}" id="">
        <label for="">الحالة</label>
        <input type="text" name="status" required id="interested-choosevalue-input" class="form-control" readonly
            value="{{ $selected_value }}" />
        <br>
        <label for="">calender</label>
        <input type="date" name="calendar" required class="form-control" id="">
        <br>
        <label for="">التفاصيل</label>
        <input type="text" name="extra_input" required class="form-control" id="">
        <br>
        <button type="submit" id="submit-interested" class="btn btn-info">Submit</button>
        <!-- Other form elements like calendar and input -->
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $("#interested-form").on("submit", function(event) {
        event.preventDefault();
        var formData = $("#interested-form").serialize();
        var userId = $("#interested-form [name='user_id']").val(); // Extract user_id value

        $.ajax({
            url: "{{ route('updated_status_call_center') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                $("#interested-modal").modal("hide");
                $('select[data-user-id='+userId+']').prop('disabled', true);


                Swal.fire({
                    icon: 'success',
                    title: 'تم تغير الحالة بنجاح',
                })
            },
            error: function(error) {
                // Handle error
                Swal.fire({
                    icon: 'error',
                    title: 'حدث خطأ ما يرجى المحاولة لاحقا'
                })
            }
        });
    });
</script>
