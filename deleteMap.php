<?php
require "./db.php";

$map_id = $_GET['map_id'];

$statement = "DELETE FROM coordinates WHERE map_id = '".$map_id."' ";
mysqli_query($con, $statement) or die("ERROR: " . mysqli_error($con));


$statement = "DELETE FROM maps WHERE id = '".$map_id."' ";
mysqli_query($con, $statement) or die("ERROR: " . mysqli_error($con));
?>