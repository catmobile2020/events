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
        @endif
        <li class="has-sub {{Route::is('admin.users.*') ? 'active' : ''}}">
            <a href=""><i class="icon-layout"></i><span class="title">Speakers</span></a>
            <ul class="nav collapse">
                <li class="{{Route::is('admin.users.create',['type'=>2]) ? 'active' : ''}}"><a href="{{route('admin.users.create',2)}}"><span class="title">Add New</span></a></li>
                <li class="{{Route::is('admin.users.index',['type'=>2]) ? 'active' : ''}}"><a href="{{route('admin.users.index',2)}}"><span class="title">Show All</span></a></li>
            </ul>
        </li>
        <li class="has-sub {{Route::is('admin.events.*') ? 'active' : ''}}">
            <a href=""><i class="icon-layout"></i><span class="title">Events</span></a>
            <ul class="nav collapse">
                <li class="{{Route::is('admin.events.create') ? 'active' : ''}}"><a href="{{route('admin.events.create')}}"><span class="title">Add New</span></a></li>
                <li class="{{Route::is('admin.events.index') ? 'active' : ''}}"><a href="{{route('admin.events.index')}}"><span class="title">Show All</span></a></li>
            </ul>
        </li>
    </ul>
    <!-- /main navigation -->
</div>
<!-- /page sidebar -->
