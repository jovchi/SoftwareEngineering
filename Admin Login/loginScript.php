<?php
include "./db.php";

$result = mysqli_query($connect, "SELECT * FROM login WHERE username = '".$_POST['username']."' AND password = '".$_POST['password']."' LIMIT 1");

if (mysqli_num_rows ( $result ) > 0)
{

    $row = mysqli_fetch_assoc($result);
    $success = true;
    $message = "Login was successfull!";

}
else
{
    $success = false;
    $message = "Invalid username or password. Please try again.";
}

$arr = array(
    "success" => $success,
    "message" => $message
);

echo json_encode($arr);
?>