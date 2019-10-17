
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Mouldifi - A fully responsive, HTML5 based admin theme">
    <meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, Mouldifi, web design, CSS3">
    <title>Events System | @yield('title')</title>
    <!-- Site favicon -->
    <link rel='shortcut icon' type='image/x-icon' href='{{asset('assets/admin/images/favicon.ico')}}' />
    <!-- /site favicon -->

    @include('admin.layouts.assets.css')

</head>
<body>

<!-- Page container -->
<div class="page-container">

   @include('admin.layouts.sidebar')

    <!-- Main container -->
    <div class="main-container">

        @include('admin.layouts.header')

        <!-- Main content -->
        @yield('content')
        <!-- /main content -->

    </div>
    <!-- /main container -->

</div>
<!-- /page container -->

@include('admin.layouts.assets.js')

</body>
</html>
