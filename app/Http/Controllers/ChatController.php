<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    public function showChat($ride_id)
    {
        $ride = Ride::findOrFail($ride_id);
        $messages = ChatMessage::where('ride_id', $ride_id)->with('user')->get();
        $userId = auth()->id(); // Get the authenticated user's ID

        // Ensure that the chat is only accessible if the ride is accepted or started
        if ($ride->status == 'Accepted' || $ride->status == 'Started') {
            return view('chat', compact('ride', 'messages', 'userId'));
        }

        // Redirect back if the ride status doesn't permit chatting
        return redirect()->route('rides.show', $ride_id)->with('error', 'Chat is only available once the ride is accepted or started.');
    }

    public function sendMessage(Request $request, $ride_id)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $message = ChatMessage::create([
            'ride_id' => $ride_id,
            'user_id' => auth()->id(),
            'message' => $request->input('message'),
        ]);

        return response()->json(['status' => true, 'message' => $message]);
    }

    public function getMessages(Request $request, $ride_id)
    {
        // Fetch messages with ID greater than the last displayed message ID
        $lastMessageId = $request->input('last_message_id', 0);
        $messages = ChatMessage::where('ride_id', $ride_id)
                               ->where('id', '>', $lastMessageId)
                               ->with('user')
                               ->get();

        return response()->json($messages);
    }
}
