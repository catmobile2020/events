@extends('admin.layouts.master')

@section('title','Events')

@section('content')
    <div class="main-content">
        <h1 class="page-title">Data Tables</h1>
        <!-- Breadcrumb -->
        <ol class="breadcrumb breadcrumb-2">
            <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><strong>Events</strong></li>
        </ol>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title">Basic Data Tables with responsive Plugin</h3>
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
                            <div class="alert alert-success text-center sr-only" id="statusResult">

                            </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>time</th>
                                    <th>Address</th>
                                    <th>Is Public</th>
                                    <th>Active</th>
                                    <th>Event Speakers</th>
                                    <th>Event Talks</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rows as $row)
                                    <tr class="gradeX">
                                        <td>{{$row->iteration}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->date}}</td>
                                        <td>{{$row->address}}</td>
                                        <td>
                                            <span class="badge badge-{{ $row->is_public == 1 ? 'success' : 'danger' }}">{{$row->is_public ? 'Yes' : 'NO'}}</span>
                                        </td>
                                        <td>
                                            @if (auth()->user()->type == 0)
                                                <select class="form-control changeStatus" name="active" data-id="{{$row->id}}">
                                                    <option value="1" {{$row->active ? 'selected' : ''}}>Yes</option>
                                                    <option value="0" {{$row->active ? '' : 'selected'}}>No</option>
                                                </select>
                                            @else
                                                <span class="badge badge-{{ $row->active == 1 ? 'success' : 'danger' }}">{{ $row->active_name}}</span>
                                            @endif
                                        </td>
                                        <td><a class="btn btn-info btn-rounded" href="{{route('admin.speakers.index',$row->id)}}">Event Speakers</a></td>
                                        <td><a class="btn btn-success btn-rounded" href="{{route('admin.talks.index',$row->id)}}">Event Talks</a></td>
                                        <td class="size-80">
                                            <div class="dropdown">
                                                <a href="" data-toggle="dropdown" class="more-link"><i class="icon-dot-3 ellipsis-icon"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{route('admin.events.edit',$row->id)}}">Edit</a></li>
{{--                                                    <li><a href="{{route('admin.events.destroy',$row->id)}}">Delete</a></li>--}}
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
                                    <th>contact phone</th>
                                    <th>contact email</th>
                                    <th>Address</th>
                                    <th>Active</th>
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

@section('js')
<script>
    $(document).on('change','.changeStatus',function () {
        let  active = $(this).val();
        let  id = $(this).data('id');
        $.ajax({
            data:{id:id,active:active},
            success:function (result) {
                $('#statusResult').removeClass('sr-only');
                $('#statusResult').html(result);
            },
            error:function (errors) {
                console.log(errors);
            }
        });
    });
</script>
@endsection
