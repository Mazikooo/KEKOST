<!-- resources/views/chatbot.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>KEKOST Chatbot</title>
    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
</head>
<body>
    <h1>Welcome to KEKOST Chatbot</h1>

    <script>
        var botmanWidget = {
            frameEndpoint: '/botman/chat',
            introMessage: 'Hi! How can I help you?',
            chatServer: '/botman',
            title: 'KEKOST Chatbot',
        };
    </script>
</body>
</html>
