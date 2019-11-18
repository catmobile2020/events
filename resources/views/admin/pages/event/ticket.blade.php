@extends('admin.layouts.master')

@section('title','Events')

@section('content')
    <div class="main-content">
        <h1 class="page-title">Data Tables</h1>
        <!-- Breadcrumb -->
        <ol class="breadcrumb breadcrumb-2">
            <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><strong>{{$event->name}} tickets</strong></li>
        </ol>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('admin.tickets.store',$event->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="count_number">Ticket Number</label>
                                    <input type="number" name="count_number" class="form-control" id="count_number" placeholder="Ticket Number">
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="alert alert-success text-center sr-only" id="statusResult">

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>code</th>
                                    <th>status</th>
                                    <th>user name</th>
                                    <th>user phone</th>
                                    <th>method type</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rows as $row)
                                    <tr class="gradeX">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$row->code}}</td>
                                        <td>
                                            <select class="form-control changeStatus" name="active" data-id="{{$row->id}}">
                                                <option value="1" {{$row->active ? 'selected' : ''}}>Yes</option>
                                                <option value="0" {{$row->active ? '' : 'selected'}}>No</option>
                                            </select>
                                        </td>
                                        <td>{{$row->user->name}}</td>
                                        <td>{{$row->user->phone}}</td>
                                        <td>{{$row->method_type_name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                {!! $rows->links() !!}
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>code</th>
                                    <th>status</th>
                                    <th>user name</th>
                                    <th>user phone</th>
                                    <th>method type</th>
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
