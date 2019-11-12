<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\NotificationResource;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.pages.home');
    }

    public function notifications()
    {
        return ['notifications'=>NotificationResource::collection(auth()->user()->notifications)];
    }
    public function readNotification($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        $notification->markAsRead();
        return redirect($notification['data']['notify']['url']);
    }

    public function readAllNotification()
    {
        $notification = auth()->user()->notifications->markAsRead();
        return redirect()->back();
    }
}
