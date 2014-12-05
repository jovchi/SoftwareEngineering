<?php
include "./db.php";

$shapes=json_decode( $_POST['jsonData'] );
$map_id = $_POST['map_id'];

//Clear all points in database that already exist
$result = mysqli_query($con,"DELETE FROM coordinates WHERE map_id = '$map_id' ") or die("ERROR: " . mysqli_error($con));

//Now add all the new points

echo "map_id: ".$map_id;
foreach ($shapes as $shape)
{
	$shape_id = $shape->id;

	
	$order_num = 0;
	
	$points = $shape->points;
	foreach ($points as $point)
	{
		$point_x = $point->x;
		$point_y = $point->y;
		
		mysqli_query($con, "INSERT INTO coordinates (x_pos, y_pos, map_id, housenumber, order_num)
											VALUES ('$point_x', '$point_y', '$map_id', '$shape_id', '$order_num')");
			$order_num++;
	}

}



//$arr2=$_POST['jsonData'];
/* return first ID as test*/
//echo $arr2;

?>