<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>chatapp</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <style>
        .hidden {
            display: none;
        }

        #wrapper {
            width: 800px;
            margin: 0 auto;
        }

        #leave-room {
            margin-bottom: 10px;
            float: right;
        }

        #user-container {
            width: 500px;
            margin: 0 auto;
            text-align: center;
        }

        #main-container {
            width: 500px;
            margin: 0 auto;
        }

        #messages {
            height: 300px;
            width: 500px;
            border: 1px solid #ccc;
            padding: 20px;
            text-align: left;
            overflow-y: scroll;
        }

        #msg-container {
            padding: 20px;
        }

        #msg {
            width: 400px;
        }

        .user {
            font-weight: bold;
        }

        .msg {
            margin-bottom: 10px;
            overflow: hidden;
        }

        .time {
            float: right;
            color: #939393;
            font-size: 13px;
        }

        .details {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="user-container">
        <label for="user">What's your name?</label>
        <input type="text" id="user" name="user">
        <button type="button" id="join-chat">Join Chat</button>
    </div>

    <div id="main-container" class="hidden">
        <button type="button" id="leave-room">Leaves</button>
        <div id="messages">

        </div>

        <div id="msg-container">
            <input type="text" id="msg" name="msg">
            <button type="button" id="send-msg">Send</button>
        </div>
    </div>

</div>



<script>
    (function(){

        var user;
        var messages = [];

        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        var count=1;
        conn.onmessage=function(e){
            var msg = JSON.parse(e.data);
            console.log("count->"+count);
            count++;
    }

        $('#join-chat').click(function(){
            user = $('#user').val();
            $('#user-container').addClass('hidden');
            $('#main-container').removeClass('hidden');

            var msg = {
                'user': user,
                'text': user + ' entered the room',
                'time': moment().format('hh:mm a')
            };
            conn.send(JSON.stringify(msg));
            $("#messages").html(msg.text+" "+msg.time);
            $('#user').val('');
        });

        $('#send-msg').click(function(){
            user = $('#user').val();

            $('#user-container').addClass('hidden');
            $('#main-container').removeClass('hidden');

            var msg = {
                'user': user,
                'text': user + ' '+$("#msg").val(),
                'time': moment().format('hh:mm a')
            };
            conn.send(JSON.stringify(msg));
            $("#messages").html(msg.text+" "+msg.time);
            $('#msg').val('');
        });

    })();
</script>
</body>
</html>