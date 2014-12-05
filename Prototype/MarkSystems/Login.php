<!DOCTYPE HTML>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<head>
    <link rel="stylesheet" type="text/css" href="./loginScreen.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<html>
    <body class="body">
        <div class="login-form">
            <div class=buttonGroup>
            <h1 class="loginTitle">Admin Login</h1>
            <span id='error'></span>
            <form id="loginForm" action="./loginScript.php" method="post">
                    <input class="username" type="text" name="username" placeholder="Username">
                    <input class="password" type="password" name="password" placeholder="Password">
                    <center><input class="loginButton" id="loginButton" type="submit" value="login"></center>
                </div>
            </form>
        </div>
    </body>
</html>

<script>
    $("#loginButton").click(function()
    {
        
        $.post( "./loginScript.php", $('#loginForm').serialize() )
            .done(function( data )
            {
                var myArray = JSON.parse(data);
                $('#error').html(myArray['message']);
            });
        
        return false;    
    });
</script>