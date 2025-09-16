<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laran Panel</title>
    <link href="{{ asset('vendor/laran/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/laran/fonts/vazir/font-face.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="font-family: Vazir">
<section class="vh-100">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        {{ html()->form('POST', route('admin.loginCheck'))->open() }}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                @foreach ($errors->all() as $error)
                                    <p> {{$error}}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <h2 class="fw-bold mb-2 text-uppercase">{{ lt('Login to admin panel') }}</h2>
                            <p class="text-white-50 mb-5">{{ lt('Please enter your login credentials') }}</p>

                            <div class="mb-4">
                                {{ html()->label(lt('Mobile'), 'mobile') }}
                                {{ html()->text('mobile', old('mobile'))->class('form-control') }}
                            </div>

                            <div class="mb-4">
                                {{ html()->label(lt('Password'), 'password') }}
                                <div class="position-relative">
                                    {{ html()->password('password', old('password'))->id('passwordInput')->class('form-control') }}
                                    <i id="togglePassword"
                                       class="fa fa-eye text-black"
                                       style="position:absolute; top:50%; transform:translateY(-50%); left:10px; cursor:pointer;"></i>
                                </div>
                            </div>
                            {{ html()->submit(lt('Login'))->class('btn btn-outline-light px-5') }}
                        </div>
                        {!! html()->form()->close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("passwordInput");
        const togglePassword = document.getElementById("togglePassword");

        togglePassword.addEventListener("click", function () {
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";

            togglePassword.classList.toggle("fa-eye");
            togglePassword.classList.toggle("fa-eye-slash");
        });
    });
</script>

<style>
    .form-label {
        color: #212121;
        font-weight: 500;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.73);
        color: #212121;
        border: 1px solid rgba(255, 255, 255, 0.4);
        transition: background-color 0.3s, color 0.3s;
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.8);
        color: #212121;
        outline: none;
        border-color: #60a5fa;
    }
</style>
