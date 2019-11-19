@extends('admin.layouts.master')

@section('title','analysis')

@section('css')
    <link href="{{asset('assets/admin/css/plugins/chartist/chartist.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="main-content">
        <h1 class="page-title">General analysis</h1>
        <!-- Breadcrumb -->
        <ol class="breadcrumb breadcrumb-2">
            <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><strong>General analysis</strong></li>
        </ol>
        <div class="row">
            <div class="col-lg-6">
                <!-- panel-->
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="panel-title">Events</div>
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
                        <div class="panel-title">Event Users Chart</div>
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
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="panel-title">articles & banners</div>
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
{{--    <script src="{{asset('assets/admin/js/plugins/flot/flot-script.js')}}"></script>--}}
    <script>
        //Flot Bar Chart
        $(function () {
            var ticks = [
                [1, "all  events"], [2, " active events"], [3, " available events"]
            ];
            var barOptions = {
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.6,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.8
                            }, {
                                opacity: 0.8
                            }]
                        }
                    }
                },
                xaxis: {
                    ticks:  ticks,
                },
                colors: ["#00B8CE"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: "x: %x, y: %y"
                }
            };
            var barData = {
                label: "bar",
                data: [
                    [1, {{$events}}],
                    [2, {{$active_events}}],
                    [3, {{$available_events}}],
                ]
            };
            $.plot($("#flot-bar-chart"), [barData], barOptions);

        });


        //Flot Pie Chart
        $(function () {

            var data = [{
                label: "events owners",
                data: '{{$events_owners}}',
                color: "#F64D2A",
            }, {
                label: "attendees",
                data: '{{$attendees}}',
                color: "#00a65a",
            }, {
                label: "speakers",
                data: '{{$speakers}}',
                color: "#f39c12",
            }];

            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });

        });
        //Flot Line Chart
        $(function () {
            var ticks = [
                [1, "articles"], [2, "banners"]
            ];
            var barOptions = {
                series: {
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.0
                            }, {
                                opacity: 0.0
                            }]
                        }
                    }
                },
                xaxis: {
                    ticks:  ticks,
                },
                colors: ["#00b8ce"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: "x: %x, y: %y"
                }
            };
            var barData = {
                label: "bar",
                data: [
                    [1, {{$articles}}],
                    [2, {{$banners}}],
                ]
            };
            $.plot($("#flot-line-chart"), [barData], barOptions);

        });
    </script>
@endsection
