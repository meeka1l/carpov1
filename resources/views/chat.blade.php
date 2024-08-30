@extends('layouts.app')

@section('content')
<div class="chat-container">
    <h2>Chat with Navigator</h2>
    <div class="chat-box" id="chat-box">
        <!-- Existing chat messages will appear here -->
        @foreach($messages as $message)
            <div class="chat-message" data-message-id="{{ $message->id }}">
                <strong>{{ $message->user_id === $userId ? 'You' : $message->user->name }}:</strong> {{ $message->message }}
            </div>
        @endforeach
    </div>
    <form id="chat-form" action="{{ route('chat.send', ['ride_id' => $ride->id]) }}" method="POST">
        @csrf
        <input type="text" name="message" id="message-input" placeholder="Type your message..." required>
        <button type="submit" class="btn-send">Send</button>
    </form>
</div>
@endsection

<style>
    .chat-container { padding: 2em; max-width: 600px; margin: auto; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .chat-box { height: 400px; border: 1px solid #ddd; border-radius: 8px; overflow-y: scroll; padding: 1em; margin-bottom: 1em; }
    .chat-message { margin-bottom: 10px; }
    input[type="text"] { width: 80%; padding: 0.5em; margin-right: 1em; }
    .btn-send { padding: 0.5em 1em; background-color: #008CBA; color: white; border: none; border-radius: 4px; cursor: pointer; }
    .btn-send:hover { background-color: #007B9A; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let lastMessageId = $('.chat-message:last').data('message-id') || 0; // Track last displayed message ID
        let userId = {{ $userId }}; // JavaScript access to the authenticated user's ID

        // Submit chat form via AJAX
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();
            let message = $('#message-input').val();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    message: message
                },
                success: function (response) {
                    if (response.status) {
                        // Append the new message to the chat box
                        let senderName = response.message.user_id === userId ? 'You' : response.message.user.name;
                        $('#chat-box').append('<div class="chat-message" data-message-id="' + response.message.id + '"><strong>' + senderName + ':</strong> ' + response.message.message + '</div>');
                        $('#message-input').val(''); // Clear the input
                        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight); // Scroll to bottom
                        lastMessageId = response.message.id; // Update the last message ID
                    } else {
                        alert(response.error);
                    }
                },
                error: function () {
                    alert('Failed to send the message. Please try again.');
                }
            });
        });

        // Poll for new messages every 5 seconds
        function fetchNewMessages() {
            $.ajax({
                url: '{{ route('chat.getMessages', ['ride_id' => $ride->id]) }}',
                method: 'GET',
                data: {
                    last_message_id: lastMessageId // Send the last displayed message ID
                },
                success: function (messages) {
                    messages.forEach(function (message) {
                        if (message.id > lastMessageId) {
                            let senderName = message.user_id === userId ? 'You' : message.user.name;
                            $('#chat-box').append('<div class="chat-message" data-message-id="' + message.id + '"><strong>' + senderName + ':</strong> ' + message.message + '</div>');
                            lastMessageId = message.id; // Update the last message ID
                        }
                    });
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight); // Scroll to bottom
                },
                error: function () {
                    console.error('Failed to fetch new messages.');
                }
            });
        }

        setInterval(fetchNewMessages, 5000); // Poll every 5 seconds
    });
</script>
