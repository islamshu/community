<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
  <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
  <meta name="author" content="PIXINVENT">
  <title>تسجيل الدخول 
  </title>
  <link rel="apple-touch-icon" href="{{asset('backend/images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('backend/images/ico/favicon.ico')}}">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
  rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('backend/css-rtl/vendors.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/forms/icheck/icheck.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('backend/vendors/css/forms/icheck/custom.css')}}">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('backend/css-rtl/app.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('backend/css-rtl/custom-rtl.css')}}">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('backend/css-rtl/core/menu/menu-types/vertical-content-menu.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('backend/css-rtl/core/colors/palette-gradient.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('backend/css-rtl/pages/login-register.css')}}">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('backend/style-rtl.css')}}">
  <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-content-menu 1-column   menu-expanded blank-page blank-page"
data-open="click" data-menu="vertical-content-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div class="p-1">
                      <img src="{{asset('backend/images/logo/logo-dark.png')}}" alt="branding logo">
                    </div>
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>محفظة كودك</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    @include('dashboard.parts._error')
                    @include('dashboard.parts._success')
                    <form class="form-horizontal form-simple" method="POST" action="{{ route('register') }}">
                        @csrf
                        <fieldset class="form-group position-relative has-icon-left mb-2 ">
                            <input type="text" class="form-control form-control-lg input-lg @error('name') is-invalid @enderror" name="name" id="name" placeholder="الاسم" value="{{ old('name') }}" required data-validation-url="{{ route('validate.input','uniqe_name') }}" />
                            <div class="form-control-position">
                                <i class="ft-user"></i>
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </fieldset>
                        
                        <fieldset class="form-group position-relative has-icon-left mb-2">
                            <input type="email" class="form-control form-control-lg input-lg @error('email') is-invalid @enderror" name="email" id="email" placeholder="البريد الإلكتروني" value="{{ old('email') }}" data-validation-url="{{ route('validate.input','email')}}" required>
                            <div class="form-control-position">
                                <i class="ft-mail"></i>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </fieldset>
                        
                        <fieldset class="form-group position-relative has-icon-left mb-1">
                            <input type="password" class="form-control form-control-lg input-lg @error('password') is-invalid @enderror" name="password" id="password" placeholder="كلمة المرور" required>
                            <div class="form-control-position">
                                <i class="la la-key"></i>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </fieldset>
                        
                        <fieldset class="form-group position-relative has-icon-left mb-1">
                            <input type="password" class="form-control form-control-lg input-lg @error('confirm_password') is-invalid @enderror" name="confirm_password" id="confirm_password" placeholder="تأكيد كلمة المرور" required>
                            <div class="form-control-position">
                                <i class="la la-key"></i>
                            </div>
                            @error('confirm_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </fieldset>
                        
                        <fieldset class="form-group position-relative has-icon-left mb-2">
                            <input type="text" class="form-control form-control-lg input-lg @error('full_name') is-invalid @enderror" name="full_name" id="full_name" placeholder="الاسم الكامل" value="{{ old('full_name') }}" required>
                            <div class="form-control-position">
                                <i class="ft-user"></i>
                            </div>
                            @error('full_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </fieldset>
                        
                        <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-user-plus"></i> تسجيل</button>
                    </form>
                    
                  </div>
                </div>
              
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <!-- BEGIN VENDOR JS-->
  <script src="{{asset('backend/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{asset('backend/vendors/js/ui/headroom.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('backend/vendors/js/forms/icheck/icheck.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('backend/vendors/js/forms/validation/jqBootstrapValidation.js')}}"
  type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{{asset('backend/js/core/app-menu.js')}}" type="text/javascript"></script>
  <script src="{{asset('backend/js/core/app.js')}}" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{{asset('backend/js/scripts/forms/form-login-register.js')}}" type="text/javascript"></script>
  <script>
    $(function () {
    $('#name').on('input', function () {
        var name = $(this).val();
        var url = $(this).data('validation-url');
        $.get(url, { name: name }, function (data) {
            if (data == 'taken') {
                $('#name').addClass('is-invalid');
                $('#name-error').text('This name is already taken.');
            } else {
                $('#name').removeClass('is-invalid');
                $('#name-error').text('');
            }
        });
    });
    $('#email').on('input', function () {
        var name = $(this).val();
        var url = $(this).data('validation-url');
        $.get(url, { name: name }, function (data) {
            if (data == 'taken') {
                $('#email').addClass('is-invalid');
                $('#email-error').text('This email is already taken.');
            } else {
                $('#email').removeClass('is-invalid');
                $('#email-error').text('');
            }
        });
    });
});

  </script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>