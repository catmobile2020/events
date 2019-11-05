<!-- Page Sidebar -->
<div class="page-sidebar">

    <!-- Site header  -->
    <header class="site-header">
        <div class="site-logo">
            <a href="{{route('admin.home')}}">
                <img src="{{asset('assets/admin/images/logo.png')}}" alt="Mouldifi" title="Mouldifi">
            </a>
        </div>
        <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i class="icon-menu"></i></a></div>
        <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse" class="mobile-menu-icon" href="#"><i class="icon-menu"></i></a></div>
    </header>
    <!-- /site header -->

    <!-- Main navigation -->
    <ul id="side-nav" class="main-menu navbar-collapse collapse">

        <li class="{{Route::is('admin.home') ? 'active' : ''}}">
            <a href="{{route('admin.home')}}">
                <i class="icon-gauge"></i><span class="title">Dashboard</span>
            </a>
        </li>
        @if (auth()->user()->type == 0)
            <li class="has-sub {{Route::is('admin.users.*') ? 'active' : ''}}">
                <a href=""><i class="icon-layout"></i><span class="title">Events Owner</span></a>
                <ul class="nav collapse">
                    <li class="{{Route::is('admin.users.create',['type'=>1]) ? 'active' : ''}}"><a href="{{route('admin.users.create',1)}}"><span class="title">Add New</span></a></li>
                    <li class="{{Route::is('admin.users.index',['type'=>1]) ? 'active' : ''}}"><a href="{{route('admin.users.index',1)}}"><span class="title">Show All</span></a></li>
                </ul>
            </li>
            <li class="has-sub {{Route::is('admin.articles.*') ? 'active' : ''}}">
                <a href=""><i class="icon-layout"></i><span class="title">Articles</span></a>
                <ul class="nav collapse">
                    <li class="{{Route::is('admin.articles.create') ? 'active' : ''}}"><a href="{{route('admin.articles.create')}}"><span class="title">Add New</span></a></li>
                    <li class="{{Route::is('admin.articles.index') ? 'active' : ''}}"><a href="{{route('admin.articles.index')}}"><span class="title">Show All</span></a></li>
                </ul>
            </li>
            <li class="has-sub {{Route::is('admin.banners.*') ? 'active' : ''}}">
                <a href=""><i class="icon-layout"></i><span class="title">Banners</span></a>
                <ul class="nav collapse">
                    <li class="{{Route::is('admin.banners.create') ? 'active' : ''}}"><a href="{{route('admin.banners.create')}}"><span class="title">Add New</span></a></li>
                    <li class="{{Route::is('admin.banners.index') ? 'active' : ''}}"><a href="{{route('admin.banners.index')}}"><span class="title">Show All</span></a></li>
                </ul>
            </li>

        @endif
        <li class="has-sub {{Route::is('admin.sponsors.*') ? 'active' : ''}}">
            <a href=""><i class="icon-layout"></i><span class="title">sponsors</span></a>
            <ul class="nav collapse">
                <li class="{{Route::is('admin.sponsors.create') ? 'active' : ''}}"><a href="{{route('admin.sponsors.create')}}"><span class="title">Add New</span></a></li>
                <li class="{{Route::is('admin.sponsors.index') ? 'active' : ''}}"><a href="{{route('admin.sponsors.index')}}"><span class="title">Show All</span></a></li>
            </ul>
        </li>
        <li class="has-sub {{Route::is('admin.partnerships.*') ? 'active' : ''}}">
            <a href=""><i class="icon-layout"></i><span class="title">partnerships</span></a>
            <ul class="nav collapse">
                <li class="{{Route::is('admin.partnerships.create') ? 'active' : ''}}"><a href="{{route('admin.partnerships.create')}}"><span class="title">Add New</span></a></li>
                <li class="{{Route::is('admin.partnerships.index') ? 'active' : ''}}"><a href="{{route('admin.partnerships.index')}}"><span class="title">Show All</span></a></li>
            </ul>
        </li>
        <li class="has-sub {{Route::is('admin.events.*') ? 'active' : ''}}">
            <a href=""><i class="icon-layout"></i><span class="title">Events</span></a>
            <ul class="nav collapse">
                <li class="{{Route::is('admin.events.create') ? 'active' : ''}}"><a href="{{route('admin.events.create')}}"><span class="title">Add New</span></a></li>
                <li class="{{Route::is('admin.events.index') ? 'active' : ''}}"><a href="{{route('admin.events.index')}}"><span class="title">Show All</span></a></li>
            </ul>
        </li>
{{--        <li class="has-sub {{Route::is('admin.testimonials.*') ? 'active' : ''}}">--}}
{{--            <a href=""><i class="icon-layout"></i><span class="title">testimonials</span></a>--}}
{{--            <ul class="nav collapse">--}}
{{--                <li class="{{Route::is('admin.testimonials.create') ? 'active' : ''}}"><a href="{{route('admin.testimonials.create')}}"><span class="title">Add New</span></a></li>--}}
{{--                <li class="{{Route::is('admin.testimonials.index') ? 'active' : ''}}"><a href="{{route('admin.testimonials.index')}}"><span class="title">Show All</span></a></li>--}}
{{--            </ul>--}}
{{--        </li>--}}
    </ul>
    <!-- /main navigation -->
</div>
<!-- /page sidebar -->
