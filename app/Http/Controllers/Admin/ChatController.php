<?php

namespace App\Http\Controllers\Admin;

use App\Chat;
use App\Event;
use App\Events\ChatEvent;
use App\Http\Resources\ChatResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index(Event $event)
    {
        return view('admin.pages.event.chat',compact('event'));
    }

    public function getMessages(Event $event)
    {
        $messages = ChatResource::collection($event->messages()->with('user')->get());
        return ['messages'=>$messages];
    }

    public function sendMessage(Request $request)
    {
        $user = auth('web')->user();
        $message = $user->chat()->create($request->only(['message','event_id']));
        $message->user;
        $message = ChatResource::make($message);
        broadcast(new ChatEvent($message));
        return ['message'=>$message];
    }

    public function deleteMessage(Chat $message)
    {
        $message->delete();
        return ['statue'=>true];
    }
}
