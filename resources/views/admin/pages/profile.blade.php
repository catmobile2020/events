@extends('admin.layouts.master')

@section('title','profile')

@section('content')
    <div class="main-content">
        <!-- Breadcrumb -->
        <ol class="breadcrumb breadcrumb-2">
            <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><strong>profile</strong></li>
        </ol>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <ul class="panel-tool-options">
                            <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                            <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                        </ul>
                    </div>
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
                        @if (session()->has('message'))
                            <div class="alert alert-info">
                                <h4>{{session()->get('message')}}</h4>
                            </div>
                        @endif
                        <form action="{{route('admin.profile.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="logo">Photo</label>
                                    <input type="file" name="photo" class="form-control" id="logo" />
                                    <img class="img-responsive" style="height: 200px" src="{{$user->photo}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Mahmoud Mohamed" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="username">username</label>
                                    <input type="text" readonly class="form-control" id="username" placeholder="Mahmoud Mohamed" value="{{$user->username}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">phone</label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="01208971865" value="{{$user->phone}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="text" name="email" class="form-control" id="email" placeholder="m.mohamed@cat.com.eg" value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="current_password">current password</label>
                                    <input type="password" name="current_password" class="form-control" id="current_password" placeholder="*********">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="password">password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="*********">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="password_confirmation">confirm password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="*********">
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
    </div>
@endsection
