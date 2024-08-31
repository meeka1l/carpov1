<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat with Navigator</title>
    <style>
        .back-button {
            display: block;
            background-color: black;
            color: white;
            border: none;
            padding: 2% 6%;
            text-align: center;
            text-decoration: none;
            border-radius: 30px;
            cursor: pointer;
            max-width: 150px;
            font-size: 1.8em;
            position: fixed;
            top: 5%;
            left: 3%;
            transform: translateY(-50%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .back-button:hover {
            background-color: #333;
            opacity: 0.9;
        }

        .chat-container {
            padding: 2em;
            max-width: 600px;
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chat-box {
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow-y: scroll;
            padding: 1em;
            margin-bottom: 1em;
        }

        .chat-message {
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 80%;
            padding: 0.5em;
            margin-right: 1em;
        }

        .btn-send {
            padding: 0.5em 1em;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-send:hover {
            background-color: #007B9A;
        }
    </style>
</head>
<body>

<a href="{{ route('rides.request', ['ride_id' => $ride->id]) }}" class="back-button">&larr;</a>

<div class="chat-container">
    <h2>Chat with Navigator</h2>
    <div class="chat-box" id="chat-box">
        <!-- Existing chat messages will appear here -->
        @foreach($messages as $message)
            <div class="chat-message" data-message-id="{{ $message->id }}">
                <strong>{{ $message->user_id === auth()->id() ? 'You' : $message->user->name }}:</strong> {{ $message->message }}
            </div>
        @endforeach
    </div>
    <form id="chat-form" action="{{ route('chat.send', ['ride' => $ride->id]) }}" method="POST">
        @csrf
        <input type="text" name="message" id="message-input" placeholder="Type your message..." required>
        <button type="submit" class="btn-send">Send</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let lastMessageId = $('.chat-message:last').data('message-id') || 0;
        let userId = {{ auth()->id() }};

        $('#chat-form').on('submit', function (e) {
            e.preventDefault();
            let message = $('#message-input').val();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    message: message
                },
                success: function (response) {
                    if (response.status) {
                        let senderName = response.message.user_id === userId ? 'You' : response.message.user.name;
                        $('#chat-box').append('<div class="chat-message" data-message-id="' + response.message.id + '"><strong>' + senderName + ':</strong> ' + response.message.message + '</div>');
                        $('#message-input').val('');
                        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                        lastMessageId = response.message.id;
                    } else {
                        alert(response.error);
                    }
                },
                error: function () {
                    alert('Failed to send the message. Please try again.');
                }
            });
        });

        function fetchNewMessages() {
            $.ajax({
                url: '{{ route('chat.getMessages', ['ride' => $ride->id]) }}',
                method: 'GET',
                data: {
                    last_message_id: lastMessageId
                },
                success: function (messages) {
                    messages.forEach(function (message) {
                        if (message.id > lastMessageId) {
                            let senderName = message.user_id === userId ? 'You' : message.user.name;
                            $('#chat-box').append('<div class="chat-message" data-message-id="' + message.id + '"><strong>' + senderName + ':</strong> ' + message.message + '</div>');
                            lastMessageId = message.id;
                        }
                    });
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                },
                error: function () {
                    console.error('Failed to fetch new messages.');
                }
            });
        }

        setInterval(fetchNewMessages, 5000);
    });
</script>

</body>
</html>
