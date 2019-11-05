@extends('admin.layouts.master')

@section('title','Events')

@section('content')
    <div class="main-content">
        <!-- Breadcrumb -->
        <ol class="breadcrumb breadcrumb-2">
            <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><strong>Events</strong></li>
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
                        <form action="{{isset($event->id) ? route('admin.events.update',$event->id) : route('admin.events.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @isset($event->id)
                                @method('PUT')
                            @endisset
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Event Name" value="{{$event->name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="date">Event Date</label>
                                    <input type="date" name="date" class="form-control" id="date" value="{{$event->date}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="desc">Event description</label>
                                    <textarea name="desc" rows="6" class="form-control" id="desc" placeholder="Event description">{{$event->desc}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="contact_phone">contact phone</label>
                                    <input type="text" name="contact_phone" class="form-control" id="contact_phone" placeholder="01208971865" value="{{$event->contact_phone}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="contact_email">contact email</label>
                                    <input type="text" name="contact_email" class="form-control" id="contact_email" placeholder="m.mohamed@cat.com.eg" value="{{$event->contact_email}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="address">Event address</label>
                                    <input type="text" name="address" class="form-control" id="address" placeholder="cairo-egypt" value="{{$event->address}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="map_link">Event map link</label>
                                    <input type="text" name="map_link" class="form-control" id="map_link" placeholder="map link" value="{{$event->map_link}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="email">have ticket</label>
                                    <select class="form-control" name="have_ticket">
                                        <option value="1" {{$event->have_ticket ? 'selected' : ''}}>Yes</option>
                                        <option value="0" {{$event->have_ticket ? '' : 'selected'}}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="email">Public Event</label>
                                    <select class="form-control" name="is_public">
                                        <option value="1" {{$event->is_public ? 'selected' : ''}}>Yes</option>
                                        <option value="0" {{$event->is_public ? '' : 'selected'}}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <h2 class="text-center">Sponsors</h2>
                                @foreach($sponsors as $sponsor)
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input type="checkbox" name="sponsor_ids[]" class="form-control" {{in_array($sponsor->id,$event->sponsors()->pluck('id')->toArray()) ? 'checked' : ''}} value="{{$sponsor->id}}">{{$sponsor->name}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <h2 class="text-center">Partnerships</h2>
                                @foreach($partnerships as $partnership)
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input type="checkbox" name="partnership_ids[]" class="form-control" {{in_array($partnership->id,$event->partnerships()->pluck('id')->toArray()) ? 'checked' : ''}} value="{{$partnership->id}}">{{$partnership->name}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="logo">Event Logo</label>
                                    <input type="file" name="logo" class="form-control" id="logo" />
                                    <img class="img-responsive" style="height: 200px" src="{{$event->logo}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="cover">Event Cover</label>
                                    <input type="file" name="cover" class="form-control" id="cover" />
                                    <img class="img-responsive" style="height: 200px" src="{{$event->cover}}">
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-4">
                                <a href="{{route('admin.events.index')}}" class="btn btn-white">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
