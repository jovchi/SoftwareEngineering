<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> <!-- Includes Jquery into the project -->

<?php
include "./db.php";
include "./objects.php";

$map_id = $_GET['map_id'];
$result = mysqli_query($con, "SELECT * FROM maps WHERE id = '$map_id' LIMIT 1");
$row = mysqli_fetch_assoc($result);
$image_url = $row['image_url'];
$developmentcode = $row['developmentcode'];

$shapes = array();
$currentHouseNumber = "0";
$currentShape = null;

$result = mysqli_query($con, "SELECT * FROM coordinates WHERE map_id = '$map_id' ORDER BY housenumber ASC, order_num ASC") or die ("ERROR: " . mysqli_error($con));

while ($row = mysqli_fetch_assoc($result))
{
if ($currentHouseNumber != $row['housenumber']) //create a new shape everytime we get to a new house
	{
	$currentShape = new Shape($row['housenumber']);
	array_push($shapes, $currentShape);
	$currentHouseNumber = $row['housenumber'];
	} 

$currentShape->addPoint(new Point($row['x_pos'],$row['y_pos']));


}

foreach($shapes as $currentShape)
{
$id = $currentShape->__get(id);
$result2 = mysqli_query($con,"SELECT * FROM mock_housemaster WHERE developmentcode='".$developmentcode."' AND housenumber = '".$id."' LIMIT 1");
$row2 = mysqli_fetch_assoc($result2);
$currentShape->__set(baseprice, $row2['BASEPRICE']);
$currentShape->__set(address, $row2['address1']);
$currentShape->__set(remarks, $row2['REMARKS']);
if ( $row2['RATIFIED_DATE'] != '0000-00-00' )
	{
	//Contract was signed
	$currentShape->__set(ratified_date, $row2['RATIFIED_DATE']);
	if ( $row['CONTRACT_DATE'] != '0000-00-00' )
	{
		//House was sold.
		$currentShape->__set(contract_date, $row2['CONTRACT_DATE']);
	}
	}
}
?>

<div id='info_floater'>
	<span id='status'>Available</span><br>
	<span id='baseprice'>Available</span><br>
	<span id='address'>Available</span><br>
	<span id='remarks'>Available</span>
</div>
<div style="float: left">
    <img id="ImageMap1" src="<?php echo $image_url; ?>" usemap="#ImageMapmapAreas" />
    <map id="ImageMapmapAreas" name="ImageMapmapAreas">
	
	<?php
	foreach($shapes as $thisShape)
	{
		$pointsAsString = $thisShape->pointsToString();

		echo "<area remarks='".$thisShape->__get(remarks)."' address='".$thisShape->__get(address)."' status='".$thisShape->getStatus()."' baseprice='".$thisShape->__get(baseprice)."' alt=\"\" title=\"\" href='#".$thisShape->__get(id)."' coords=\"" . $pointsAsString . "\" shape=\"poly\" data-maphilight='{\"strokeColor\":\"0000ff\",\"strokeWidth\":1,\"fillColor\":\"00ff00\",\"fillOpacity\":0.1}' />";
	}
	?>
		</map>
</div>

<style>
#info_floater{
	position:absolute;
	background-color: white;
	padding:10px;
	border: 1px solid black;
	z-index: 99;
}
</style>
  <script language="javascript" src="./js/jquery.maphilight.js"></script>
  
  <script>
jQuery(function()
                            {
             jQuery('#ImageMap1').maphilight();
                            });
$('area').hover(function(){
console.log("Area hover...");
	$('#info_floater #status').html( $(this).attr("status") );
	$('#info_floater #baseprice').html( $(this).attr("baseprice") );
	$('#info_floater #address').html( $(this).attr("address") );
	$('#info_floater #remarks').html( $(this).attr("remarks") );
});

$('area').mouseleave(function(){
$('#info_floater').css("display","none");
});

$('area').mouseenter(function(){
$('#info_floater').css("display","block");
});

$(document).mousemove( function(e) {
   mouseX = e.pageX; 
   mouseY = e.pageY;
   $('#info_floater').offset({left:mouseX + 10, top:mouseY + 10});
});  
	 $('.info').maphilight({
      fillColor: '008800'
 });
</script>