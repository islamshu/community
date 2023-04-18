<!DOCTYPE html>
<html>

<head>
    <title>Subscribe to Our Mailing List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="{{ asset('front_css.css') }}">



    <style>
        body {
            background-image: url('https://communityapp.arabicreators.com/assets/header-c80fc340.png');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        
        form {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        
        h1 {
            text-align: center;
            color: #333;
        }
        input[type="text"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            font-size: 16px;
        }
        input[type="email"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            font-size: 16px;
        }
        
        button[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        button[type="submit"]:hover {
            background-color: #555;
        }
        
        img {
            display: block;
            margin: 0 auto;
            padding: 20px;
            border-radius: 23px;
            max-width: 200px;
            height: auto;
            background: #323a52;
            margin-bottom: 20px;
        }
        .invalid-feedback{
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form id="submit-form" method="post">
        <img src="https://communityapp.arabicreators.com/assets/logo-59046dfd.png" alt="Company Logo">
        @php
            $date = today()->format('Y-m-d');
        @endphp
        @csrf
        <h1>الاشتراك في جلسة تاريخ <span style="color: red">{{ $date }}</span> </h1>
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="text" name="name" placeholder="ادخل الاسم">
        <div class="invalid-feedback">
        </div>
        <input type="email" name="email" placeholder="ادخل البريد الاكتروني">
        <div class="invalid-feedback">
        </div>
        <button type="submit">Subscribe</button>
    </form>
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
                } else if(response.responseJSON.status =='er') {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.error,
                    }).then((result) => {
                    location.replace('https://communityapp.arabicreators.com/signIn');
                });

                }else if(response.responseJSON.status == 'erere'){
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