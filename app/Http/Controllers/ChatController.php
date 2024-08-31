<?php
namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Ride;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Ride $ride)
    {
        $messages = ChatMessage::where('ride_id', $ride->id)->with('user')->get();
        return view('chat', compact('ride', 'messages'));
    }

    public function send(Request $request, Ride $ride)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = ChatMessage::create([
            'user_id' => auth()->id(),
            'ride_id' => $ride->id,
            'message' => $request->message,
        ]);

        return response()->json(['status' => true, 'message' => $message]);
    }

    public function getMessages(Ride $ride, Request $request)
    {
        $lastMessageId = $request->input('last_message_id', 0);
        $messages = ChatMessage::where('ride_id', $ride->id)
                           ->where('id', '>', $lastMessageId)
                           ->with('user')
                           ->get();

        return response()->json($messages);
    }
}
