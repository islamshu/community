<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل حضور</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.all.min.js"></script>

    <style>
        .session-register {
            padding: clamp(8.5rem, 1.591rem + 4.55vw, 5rem) clamp(0.625rem, -1.875rem + 12.5vw, 7.5rem);
            background-image: url("https://community.arabicreators.com/assets/header-c80fc340.png");
            max-height: 100vh;
        }

        .logo {
            clamp(18.25rem, 6.705rem + 22.73vw, 23.75rem)
            height: clamp(8.75rem, 6.477rem + 11.36vw, 15rem);
            background-color: #08324b;
            text-align: center
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
            margin-top: -7%;

        }
    </style>
</head>

<body>
    <section class="session-register w-100">
        <div class="container p-0">
            <div class="form-wrapper p-3">
                <form action="" class="w-100 m-auto" id="submit-form">
                    <div class="logo p-3 rounded-5 mb-5 m-auto">
                        <img src="https://community.arabicreators.com/assets/logo-59046dfd.png" alt="Company Logo">
                    </div>
                    <?php
                        $date = today()->format('Y-m-d');
                    ?>
                    @csrf
                    <h3 class="text-center">
                        الاشتراك في تاريخ <strong class="text-warning">{{ $date }}</strong>
                        </h3>
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fs-5 text-white">ادخل الإسم</label>
                        <input type="text" class="form-control p-2 fs-5 text-end" id="name" name="name"
                            placeholder="أدخل الإسم" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label fs-5 text-white">أدخل البريد
                            الإلكتروني</label>
                        <input type="email" class="form-control p-2 fs-5 text-ends" id="email" name="email"
                            placeholder="name@example.com" />
                    </div>
                    <button type="submit" class="btn btn-primary fs-5 m-auto d-block">
                        حفظ
                    </button>
                </form>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
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
                            location.replace('https://community.arabicreators.com/signIn');
                        });

                    } else if (response.responseJSON.status == 'erere') {
                        Swal.fire({
                            icon: 'error',
                            title: response.responseJSON.error,
                        }).then((result) => {
                            location.replace('https://community.arabicreators.com/packages');
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
</body>

</html>
