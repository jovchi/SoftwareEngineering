<?php
require('./db.php'); 
$developmentcode = $_POST['developmentcode'];
$filePath = $_POST['filePath'];

$result = mysqli_query($con,"INSERT INTO maps (developmentcode, image_url)
VALUES ('$developmentcode', '$filePath')") or die( mysqli_error($con) );

$map_id = mysqli_insert_id($con);

echo $map_id;



?>