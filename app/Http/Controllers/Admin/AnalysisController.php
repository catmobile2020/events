<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Banner;
use App\Event;
use App\Speaker;
use App\User;
use App\Http\Controllers\Controller;

class AnalysisController extends Controller
{
    public function index()
    {
        $events = Event::query()->count();
        $active_events = Event::active()->count();
        $available_events= Event::available()->count();
        $events_owners = User::where('type',1)->count();
        $attendees = User::where('type',2)->count();
        $speakers = Speaker::count();
        $articles = Article::count();
        $banners = Banner::count();
        return view('admin.pages.general.analysis',compact(
          'events','active_events','available_events','events_owners','attendees','speakers','articles','banners'
        ));
    }
}
