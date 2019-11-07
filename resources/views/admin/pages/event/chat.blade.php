@extends('admin.layouts.master')

@section('title','Events')

@section('content')
    <div class="main-content">
        <h1 class="page-title">Event Chat</h1>
        <!-- Breadcrumb -->
        <ol class="breadcrumb breadcrumb-2">
            <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><strong>{{$event->name}}</strong></li>
        </ol>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title">Comments</h3>
                        <ul class="panel-tool-options">
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i class="icon-cog"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#"><i class="icon-arrows-ccw"></i> Update data</a></li>
                                    <li><a href="#"><i class="icon-list"></i> Detailed log</a></li>
                                    <li><a href="#"><i class="icon-chart-pie"></i> Statistics</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#"><i class="icon-cancel"></i> Clear list</a></li>
                                </ul>
                            </li>
                            <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                            <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                        </ul>
                    </div>

                    <chat :event_id="{{$event->id}}"></chat>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer-main">
            &copy; 2016 <strong>Mouldifi</strong> Admin Theme by <a target="_blank" href="#/">G-axon</a>
        </footer>
        <!-- /footer -->

    </div>
@endsection
