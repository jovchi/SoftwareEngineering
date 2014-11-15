<!DOCTYPE HTML>
<!--Author: Richard Cerone and Daniel Read--->
<!--Import JQuery-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<head>
    <!--Import CSS Style sheet-->
    <link rel="stylesheet" type="text/css" href="./loginScreen.css">
    <!--Import Font Style-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<html>
    <body class="body">
        <div class="login-form">
            <div class=buttonGroup>
            <!--Title-->
            <h1 class="loginTitle">Admin Login</h1>
            <!--If login fails error shows in span-->
            <span id='error' class="error"></span>
            <!--Login form: username field, password field, login button-->
            <form id="loginForm" action="./loginScript.php" method="post">
                    <input class="username" type="text" name="username" placeholder="Username">
                    <input class="password" type="password" name="password" placeholder="Password">
                    <center><input class="loginButton" id="loginButton" type="submit" value="login"></center>
                </div>
            </form>
        </div>
    </body>
</html> 
<!--Script send login credentials to the database and sees if they are valid-->
<script>
    $("#loginButton").click(function()
    {
        //Serialize data in the login-form field and post data to the loginScript.
        $.post( "./loginScript.php", $('#loginForm').serialize() )
            .done(function( data )
            {
                //Parse return data from loginScript into array.
                var myArray = JSON.parse(data);  
                if (myArray['success'] == true) //Check if login is true.
                {
                   window.location.replace("adminPanel.php"); //Load admin panel.
                }
                else if (myArray['success'] == false) //Login failed.
                {
                    $('#error').html(myArray['message']); //Display error in span.
                }    
            });
        return false;    
    });
</script>