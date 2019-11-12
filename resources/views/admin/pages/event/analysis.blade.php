@extends('admin.layouts.master')

@section('title','analysis')

@section('css')
    <link href="{{asset('assets/admin/css/plugins/chartist/chartist.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="main-content">
        <h1 class="page-title">{{$event->name}} analysis</h1>
        <!-- Breadcrumb -->
        <ol class="breadcrumb breadcrumb-2">
            <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><strong>{{$event->name}} analysis</strong></li>
        </ol>
        <div class="row">
            <div class="col-lg-6">
                <!-- panel-->
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="panel-title">Bar Chart Example</div>
                        <ul class="panel-tool-options">
                            <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                            <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                        </ul>
                    </div>
                    <!-- panel body -->
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div id="flot-bar-chart" class="flot-chart-content"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="panel-title">Line Chart Example</div>
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
                    <!-- panel body -->
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div id="flot-line-chart" class="flot-chart-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="panel-title">Pie Chart Example</div>
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
                    <!-- panel body -->
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div id="flot-pie-chart" class="flot-chart-pie-content"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- panel-->
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="panel-title">Bar Chart Example</div>
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
                    <!-- panel body -->
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div id="flot-bar-chart" class="flot-chart-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="panel-title">Simple pie chart</div>
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
                    <!-- panel body -->
                    <div class="panel-body">
                        <div id="ct-chart5" class="ct-perfect-fourth"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="panel-title">Gauge Chart Example</div>
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
                    <!-- panel body -->
                    <div class="panel-body">
                        <div id="ct-chart6" class="ct-perfect-fourth"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('assets/admin/js/plugins/chartist/chartist.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/plugins/chartist/chartist-script.js')}}"></script>

    <script src="{{asset('assets/admin/js/plugins/flot/jquery.flot.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/plugins/flot/jquery.flot.resize.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/plugins/flot/jquery.flot.pie.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/plugins/flot/jquery.flot.time.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/plugins/flot/flot-script.js')}}"></script>
@endsection
