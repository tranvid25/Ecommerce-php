<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="chat">
        <ul id="messages"></ul>
        <input id="message-input" type="text" placeholder="Type a message">
        <button onclick="sendMessage()">Send</button>
    </div>

    {{-- Load app.js --}}
    @vite('resources/js/app.js')

    <script>
        // Gửi tin nhắn về backend
        function sendMessage() {
            const message = document.getElementById('message-input').value;
            axios.post('/send-message', { message: message })
                .then(() => {
                    document.getElementById('message-input').value = '';
                });
        }

        // Nhận tin nhắn qua WebSocket (BeyondCode Laravel WebSockets)
        window.Echo.channel('chat-channel')
            .listen('.message.sent', (e) => {
                const messages = document.getElementById('messages');
                const newMessage = document.createElement('li');
                newMessage.textContent = e.message;
                messages.appendChild(newMessage);
            });
    </script>
</body>
</html>


