@extends('admin.layouts.master')

@section('title','Event Talks')

@section('content')
    <div class="main-content">
        <h1 class="page-title">Event Name : {{$event->name}}</h1>
        <!-- Breadcrumb -->
        <ol class="breadcrumb breadcrumb-2">
            <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><strong>{{$event->name}} Talks</strong></li>
        </ol>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title">
                            <a class="btn btn-success btn-rounded" href="{{route('admin.talks.create',$event->id)}}">Add Speaker</a>
                        </h3>
                        <ul class="panel-tool-options">
                            <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                            <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        @if (session()->has('message'))
                            <div class="alert alert-info">
                               <h4>{{session()->get('message')}}</h4>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>time</th>
                                    <th>duration</th>
                                    <th>speaker</th>
                                    <th>Talk Feedback</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rows as $row)
                                    <tr class="gradeX">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{\Carbon\Carbon::parse($row->time)->format('h:i A')}}</td>
                                        <td>{{$row->duration}}</td>
                                        <td>{{$row->speaker->name}}</td>
                                        <td><a class="btn btn-danger btn-rounded" href="{{route('admin.talks.feedback',['event'=>$row->event_id,$row->id])}}">Talk Feedback</a></td>
                                        <td class="size-80">
                                            <div class="dropdown">
                                                <a href="" data-toggle="dropdown" class="more-link"><i class="icon-dot-3 ellipsis-icon"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{route('admin.talks.edit',['event'=>$row->event_id,$row->id])}}">Edit</a></li>
                                                    <li><a href="{{route('admin.talks.destroy',['event'=>$row->event_id,$row->id])}}">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                {!! $rows->links() !!}
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>time</th>
                                    <th>duration</th>
                                    <th>speaker</th>
                                    <th>Talk Feedback</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
