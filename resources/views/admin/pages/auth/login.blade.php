<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Mouldifi - A fully responsive, HTML5 based admin theme">
    <meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, Mouldifi, web design, CSS3">
    <title>Mouldifi | Login</title>
    <!-- Site favicon -->
    <link rel='shortcut icon' type='image/x-icon' href='{{asset('assets/admin/images/favicon.ico')}}' />
    <!-- /site favicon -->

    <!-- Entypo font stylesheet -->
    <link href="{{asset('assets/admin/css/entypo.css')}}" rel="stylesheet">
    <!-- /entypo font stylesheet -->

    <!-- Font awesome stylesheet -->
    <link href="{{asset('assets/admin/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- /font awesome stylesheet -->

    <!-- Bootstrap stylesheet min version -->
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- /bootstrap stylesheet min version -->

    <!-- Mouldifi core stylesheet -->
    <link href="{{asset('assets/admin/css/mouldifi-core.css')}}" rel="stylesheet">
    <!-- /mouldifi core stylesheet -->

    <link href="{{asset('assets/admin/css/mouldifi-forms.css')}}" rel="stylesheet">

    <!-- Bootstrap RTL stylesheet min version -->
{{--    <link href="{{asset('assets/admin/css/bootstrap-rtl.min.css')}}" rel="stylesheet">--}}
    <!-- /bootstrap rtl stylesheet min version -->

    <!-- Mouldifi RTL core stylesheet -->
{{--    <link href="{{asset('assets/admin/css/mouldifi-rtl-core.css')}}" rel="stylesheet">--}}
    <!-- /mouldifi rtl core stylesheet -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{asset('assets/admin/js/html5shiv.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/respond.min.js')}}"></script>
    <![endif]-->


</head>
<body class="login-page">
<div class="login-container">
    <div class="login-branding">
        <a href="index.html"><img src="{{asset('assets/admin/images/logo.png')}}" alt="Mouldifi" title="Mouldifi"></a>
    </div>
    <div class="login-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            @if (session()->has('message'))
                <div class="alert alert-info">
                    <h4>{{session()->get('message')}}</h4>
                </div>
            @endif
        <h2><strong>Welcome</strong>, please login</h2>
        <form method="POST" action="{{ route('admin.login') }}">
           @csrf
            <div class="form-group{{ $errors->has('username') || $errors->has('email') ? ' has-error' : '' }}">

                <input type="text" class="form-control" name="username" placeholder="E-Mail / Username" value="{{old('username') }}" required autofocus>

                @if ($errors->has('username'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('username')}}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                <input id="password" type="password" placeholder="Password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">
                    Login
                </button>


            </div>
        </form>
    </div>
</div>
<!--Load JQuery-->
<script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
</body>
</html>
