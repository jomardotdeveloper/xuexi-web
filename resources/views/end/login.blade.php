<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Xuexi - Login </title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <center>
                                        <img src="{{ asset('images/logo.png') }}" alt="" height="50px">
                                    </center>

                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    @include('error.danger')
                                    <form action="{{ route('end.login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" class="form-control" value="student@test.com" required name="email">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" class="form-control" name="password" value="123" required>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{  asset('vendor/global/global.min.js')}}"></script>
	<script src="{{  asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{  asset('js/custom.min.js')}}"></script>
    <script src="{{  asset('js/deznav-init.js')}}"></script>

</body>

</html>
