<?php

include "./db.php"; //Connect to database.
$map_id = $_REQUEST['map_id'];
$result = mysqli_query($con,"SELECT *
                FROM maps
                WHERE 
        maps.id = '$map_id' ") or exit("QUERY FAILED!");

list($map_id, $content, $name, $type, $size) = mysql_fetch_array($result);
header("Content-type: image/png");
header("Content-Disposition: attachment; filename= $name");

function resize($contents, $desired_width, $desired_height) {
    $im = imagecreatefromstring($contents);
    $new = imagecreatetruecolor($desired_width, $desired_height);
    $x = imagesx($im);
    $y = imagesy($im);
    imagecopyresampled($new, $im, 0, 0, 0, 0, $desired_width, $desired_height, $x, $y);
    imagedestroy($im);
    imagepng($new, null, 85);
    echo $new;
}

if ($_REQUEST['thumbnail'] == "true") {
    resize($content, 100, 100);
} else {
    echo resize($content, 500, 333);
}
?>


