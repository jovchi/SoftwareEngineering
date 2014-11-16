<?php
//Author: Richard Cerone and Daniel Read
//Include database connection.
include "./db.php";

//Pull admin login credentials from the database.
$result = mysqli_query($connect, "SELECT * FROM login WHERE username = '".
                       $_POST['username']."' AND password = '".$_POST['password']."' LIMIT 1");

if (mysqli_num_rows ( $result ) > 0) //Check that database isn't empty.
{
    $row = mysqli_fetch_assoc($result); //Fetch row info recieved from database.
    $success = true; //Login successful.
    $message = "login successful"; //Load string for user to recieve.
}
else
{
    $success = false; //Login failed.
    $message = "Invalid username or password. Please try again."; 
}

    $success = true; //Login successful.
    $message = "login successful"; //Load string for user to recieve.

//Load data into array.
$arr = array(
    "success" => $success,
    "message" => $message
);

echo json_encode($arr); //Use json to pass all the info back to login.
?>