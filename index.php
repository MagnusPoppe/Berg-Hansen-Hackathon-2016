
<head>

    <meta charset="utf-8">
    
    <title>RooMe</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="apple-touch-icon" href="touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, minimum-scale=0.4, maximum-scale=0.4, user-scalable=no">
    
    <script>var i = 0</script>
</head>

<body>

    <header>
        <div id="icon1">
            <img src="image/menu_icon.png">
        </div>
        <div id="icon2">
            <img src="image/chat_icon.png">
        </div>

    </header>
    
    <div id="textarea">
        <div class="to"><div class="fromyou"><p>Good afternoon, Olivia</p></div></div>
        <div class="to"><div class="fromyou"><p>Want to make new friends and save money while staying at hotels? Just let me know where and when you’re going, and I’ll show you potential roommates and available hotels. It’s that simple!
                </p></div></div>
        <div class="to"><div class="fromyou"><p>Now let’s get to it! I’m ready for you.</p></div></div>
    </div>
    
    <div id="footer">
        <form id="send-message-area">
            <textarea name="message" id="send" maxlength = '100' placeholder="Type a message..."></textarea>
            <div id="send-knapp" action="search.php"><h1>Send</h1></div>
        </form>
    </div>
    
    <script>
    $("#send-knapp").click(
        function() {
            $.ajax({
                url: 'search.php', //Hvilken fil?
                type: "post",
                data: {"search": document.getElementById("send").value, "nr" : i++}, //Hva sendes til tjeneren
                success: function(results) {
                    document.getElementById("textarea").innerHTML += results;
                    document.getElementById("send").value = "";
                }//hva skjer hvis dette var en suksess?
            });
        }
    );
    </script>
</body>
</html>