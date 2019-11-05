@extends('admin.layouts.master')

@section('title','testimonials')

@section('content')
    <div class="main-content">
        <!-- Breadcrumb -->
        <ol class="breadcrumb breadcrumb-2">
            <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><strong>testimonials</strong></li>
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
                        <form action="{{isset($testimonial->id) ? route('admin.testimonials.update',[$event->id,$testimonial->id]) : route('admin.testimonials.store',$event->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @isset($testimonial->id)
                                @method('PUT')
                            @endisset
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="title">name</label>
                                    <input type="text" name="name" class="form-control" id="title" placeholder="name" value="{{$testimonial->name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Article Status</label>
                                    <select class="form-control" name="active">
                                        <option value="1" {{$testimonial->active ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{$testimonial->active ? '' : 'selected'}}>DisActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea rows="6" type="text" name="desc" class="form-control" id="desc" placeholder="Description">{{$testimonial->desc}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="logo">Photo</label>
                                    <input type="file" name="photo" class="form-control" id="logo" />
                                    <img class="img-responsive" style="height: 200px" src="{{$testimonial->photo}}">
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4">
                                <a href="{{route('admin.testimonials.index',$event->id)}}" class="btn btn-white">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
