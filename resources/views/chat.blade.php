<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <title>Carpo Chat</title>

    <style>

    
    
    
       /* Loading screen styles */
       #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #1e8573;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Text animation */
    .loading-text {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .text-animate {
        font-family: 'Krona One', sans-serif;
        color: #ffffff;
        font-size: 2em;
        opacity: 0;
        animation: fadeInOut 4s ease-in-out infinite;
    }

    .text-animate:nth-child(2) {
        animation-delay: 1s;
    }

    .text-animate:nth-child(3) {
        animation-delay: 2s;
    }

    .text-animate:nth-child(4) {
        animation-delay: 3s;
    }

    @keyframes fadeInOut {
        0%, 100% {
            opacity: 0;
            transform: translateY(-10px);
        }
        25%, 75% {
            opacity: 1;
            transform: translateY(0);
        }
    }




        .cyantext {
            color: #1e8573;
            font-size: 1.5em;
        }

        h1 {
            font-size: 1.5em; /* Larger font size for headings */
            color: #333;
            font-family: 'Krona One', sans-serif;
            margin-bottom: 10%;
            margin-left: 30%;
            margin-right: 30%;
            margin-top: 20%;
        }

        .back-button {
            display: block;
            background-color: black;
            color: white;
            border: none;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 30px;
            cursor: pointer;
            max-width: 150px;
            font-size: 1em;
            position: fixed;
            top: 5%;
            left: 3%;
            transform: translateY(-50%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            margin: 0;
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
            padding: 10px;
            border-radius: 8px;
            max-width: 70%;
            word-wrap: break-word;
        }

        /* Messages from 'You' aligned to the right */
        .chat-message.you {
            background-color: #DCF8C6; /* Light green */
            text-align: right;
            margin-left: auto;
        }

        /* Messages from other users aligned to the left */
        .chat-message.other {
            background-color: #f1f1f1; /* Light gray */
            text-align: left;
            margin-right: auto;
        }

        .input-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        input[type="text"] {
            flex: 1;
            padding: 0.5em;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-send {
            padding: 0.5em 1em;
            background-color: #08c8a6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-send:hover {
            background-color: #077a66;
        }

        .warning-message {
            margin-top: 1em;
            font-size: 0.85em;
            color: #d9534f; /* Bootstrap's 'danger' color */
            text-align: center;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
    </style>
</head>
<body>
<div id="loading-screen">
        <div class="loading-text">
            <span class="text-animate">CARPO</span>
            <span class="text-animate">CONNECT</span>
            <span class="text-animate">COMMUTE</span>
            <span class="text-animate">CARPOOL</span>
        </div>
    </div>
<h1><span class="cyantext">CARPO </span>CHAT</h1>

<button onclick="history.back()" class="back-button">&larr;</button>

<div class="chat-container">
    <div class="chat-box" id="chat-box">
        <!-- Existing chat messages will appear here -->
        @foreach($messages as $message)
            <div class="chat-message {{ $message->user_id === auth()->id() ? 'you' : 'other' }}" data-message-id="{{ $message->id }}">
                <strong>{{ $message->user_id === auth()->id() ? 'You' : $message->user->name }}:</strong> {{ $message->message }}
            </div>
        @endforeach
    </div>
    <form id="chat-form" action="{{ route('chat.send', ['ride' => $ride->id]) }}" method="POST" class="input-container">
        @csrf
        <input type="text" name="message" id="message-input" placeholder="Type your message..." required>
        <button type="submit" class="btn-send">Send</button>
    </form>
    <p class="warning-message">
    ⚠️ Please do not share personal information, passwords, or sensitive data in this chat.
    </p>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

        
window.addEventListener('load', function() {
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            // Show the loading screen initially
            loadingScreen.style.opacity = '1';
            
            // Hide the loading screen after 5 seconds
            setTimeout(() => {
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 1000); // Match the transition duration
            }, 5000); // Display for 5 seconds
        }
    });

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
                        let senderClass = response.message.user_id === userId ? 'you' : 'other';
                        let senderName = response.message.user_id === userId ? 'You' : response.message.user.name;
                        $('#chat-box').append('<div class="chat-message ' + senderClass + '" data-message-id="' + response.message.id + '"><strong>' + senderName + ':</strong> ' + response.message.message + '</div>');
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
                            let senderClass = message.user_id === userId ? 'you' : 'other';
                            let senderName = message.user_id === userId ? 'You' : message.user.name;
                            $('#chat-box').append('<div class="chat-message ' + senderClass + '" data-message-id="' + message.id + '"><strong>' + senderName + ':</strong> ' + message.message + '</div>');
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
