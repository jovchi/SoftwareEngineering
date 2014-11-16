<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> <!-- Includes Jquery into the project -->

<?php
include "./db.php";

$developmentcode = "1A";
?>
<div class="container2">

    <div class="right2">
	<select class='fullWidth' name="select_addresses" size="5">
	<?php
	$result = mysqli_query($con,"SELECT address1 FROM mock_housemaster WHERE developmentcode = '".$developmentcode."' ");
	while ($row = mysqli_fetch_assoc($result))
	{
	echo "<option>".$row['address1']."</option>";
	}
	?>
	</select>
	
	</div>
    <div class="left2">
	
				  <div id="main" class="container3">

					<form>
					<div class="row">
					  <div class="span6">
					  <textarea id='newCords' rows=3 name="coords1" class="canvas-area input-xxlarge" disabled 
						placeholder="Shape Coordinates" 
						data-image-url="./map_images/mapExample.png"></textarea>
					  </div>
					</div>
					</form>
					
					<div id='areaViewer'>
					</div>
					</div>
	</div>
	URL: <input type='text'></input>
</div>


<style>

.fullWidth{
width: 100%;
}
.clearBoth {
clear:both;
}
#ImageMap1 {
	width:100%;
}
.container2 {
    width:100%;
    border:1px solid;
}
.left2 {
    width:auto;
    background:red;
    overflow:scroll;
}
.right2 {
    width:200px;
    background:blue;
    float:right;
}
</style>

 <script language="javascript" src="./js/jquery.canvasAreaDraw2.js"></script>
  <script language="javascript" src="./js/jquery.maphilight.js"></script>
<script>
// This is where the jQuery goes ... you hook to the object by using $( "nameOfObject" ).   You can use # to refer to an id or . to refer to a class of objects
$( "#testingDiv" ).hover(
  function() {
	alert("worked"); //popup alert on screen
  }
);
jQuery(function()
                            {
             jQuery('#ImageMap1').maphilight();
                            });
$(document).mousemove( function(e) {
   mouseX = e.pageX; 
   mouseY = e.pageY;
});  
	 $('.info').maphilight({
      fillColor: '008800'
 });

 $("#addCanvas").click(
	function(){
	var co_ordinates = $('#newCords').val().split(',');
	var canvas = document.getElementById('newCanvas');
	var context = canvas.getContext('2d');
	var i = 0;
	context.beginPath();
    context.moveTo(co_ordinates[i], co_ordinates[i+1]);
	i = 2;
	while ( (co_ordinates.length) != i)
		{
		context.lineTo(co_ordinates[i],co_ordinates[i+1]);
		i+=2;
		}
	
	
	
	  // complete custom shape
      context.closePath();
      context.lineWidth = 8;
      context.strokeStyle = 'blue';
      context.stroke();
	}
 );
 
 $("#getCanvas").click(
	function(){
	alert('getCanvas');
	var canvas = document.getElementById('newCanvas');
      var context = canvas.getContext('2d');

      // begin custom shape
      context.beginPath();
      context.moveTo(209, 98);
      context.lineTo(210,82);
      context.lineTo(232,83);
	  context.lineTo(232,98);

      // complete custom shape
      context.closePath();
      context.lineWidth = 2;
      context.strokeStyle = 'blue';
      context.stroke();
	}
 );
 
$(".info").mouseenter(
	function(){

		$('#info_popup').css({'display':'block'});
		 $('#info_popup').css({'top':mouseY,'left':mouseX});
	}
);
 $(".info").mouseleave(
	function(){
		 $('#info_popup').css({'display':'none'});
	}
);
</script>


 <script>
         $("#editMap").click(function() 
            {
                $("#portal").load("editMap.php"); //Load updateMap.php into portal.
            });
    </script>