<!DOCTYPE html>
<html>

<head>
    <title>Subscribe to Our Mailing List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('front_css.css') }}">


    <style>
        .session-register {
            padding: clamp(8.5rem, 1.591rem + 4.55vw, 5rem) clamp(0.625rem, -1.875rem + 12.5vw, 7.5rem);
            background-image: url("../../assets/header.png");
            max-height: 100vh;
        }

        .logo {
            width: clamp(11.25rem, 6.705rem + 22.73vw, 23.75rem);
            height: clamp(8.75rem, 6.477rem + 11.36vw, 15rem);
            background-color: #08324b;
        }

        .form-wrapper {
            width: clamp(21.25rem, 17.614rem + 18.18vw, 31.25rem);
            margin-inline: auto;
            /* From https://css.glass */
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body>
    <section class="session-register w-100">
        <div class="container p-0">
            <div class="form-wrapper p-3">

                <form id="submit-form" method="post" class="w-100 m-auto">
                    <div class="logo p-3 rounded-5 mb-5 m-auto">
                        <img src="../../assets/logo.png" alt="" />
                        @php
                            $date = today()->format('Y-m-d');
                        @endphp
                        @csrf
                        <h1>الاشتراك في جلسة تاريخ <span style="color: red">{{ $date }}</span> </h1>
                        <input type="hidden" name="date" value="{{ $date }}">

                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fs-5 text-white">ادخل الإسم</label>
                        <input type="text" class="form-control p-2 fs-5" id="name" name="email"
                            placeholder="أدخل الإسم" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fs-5 text-white">أدخل البريد
                            الإلكتروني</label>
                        <input type="email" class="form-control p-2 fs-5" id="email" name="email"
                            placeholder="name@example.com" />
                    </div>
                    <button type="submit" class="btn btn-primary fs-5 m-auto d-block">
                        حفظ
                    </button>
                </form>
            </div>
        </div>
    </section>
</body>
<script>
    $("#submit-form").submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: "{{ route('register_email') }}",
            data: new FormData($('#submit-form')[0]),
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم الارسال بنجاح !',
                })
                $('.invalid-feedback').empty();
                $("#submit-form").trigger('reset');

            },
            error: function(response) {

                var message = response.responseJSON.errors
                var message = response.responseJSON.errors

                if (response.responseJSON.status == 'err') {
                    Swal.fire({
                        icon: 'error',
                        title: message,
                    })
                } else if (response.responseJSON.status == 'er') {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.error,
                    }).then((result) => {
                        location.replace('https://communityapp.arabicreators.com/signIn');
                    });

                } else if (response.responseJSON.status == 'erere') {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.error,
                    }).then((result) => {
                        location.replace('https://communityapp.arabicreators.com/packages');
                    });

                }
                console.log(response.responseJSON.status);
                // If form submission fails, display validation errors in the modal

                // $('.invalid-feedback').empty();
                // $('form').find('.is-invalid').removeClass('is-invalid');
                // var errors = response.responseJSON.errors;
                // $.each(errors, function(field, messages) {
                //     var input = $('#submit-form').find('[name="' + field + '"]');
                //     input.addClass('is-invalid');
                //     input.next('.invalid-feedback').html(messages[0]);
                // });
            }
        });
    });
</script>

</html>
