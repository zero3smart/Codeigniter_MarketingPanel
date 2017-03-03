<html>
<head>
    <!--
     * Author:    Gianluca Guarini
     * Contact:   gianluca.guarini@gmail.com
     * Website:   http://www.gianlucaguarini.com/
     * Twitter:   @gianlucaguarini
    -->
    <title>Push notification server streaming on a MySQL db</title>
    <style>
        dd, dt {
            float: left;
            margin: 0;
            padding: 5px;
            clear: both;
            display: block;
            width: 100%;

        }

        dt {
            background: #ddd;
        }

        time {
            color: gray;
        }
    </style>
</head>
<body>
<time></time>
<div id="container">Loading ss...</div>
<div id="db_status">Loading ss...</div>
<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script>

    // create a new websocket
    var socket = io.connect('http://54.187.12.50:8080');
    // on message received we print all the data inside the #container div
    socket.on('notification', function (data) {
        console.log(data);
        document.getElementById("container").innerHTML = data;
    });
</script>
</body>
</html>