<!DOCTYPE HTML>
<!--Author: Daniel Read, Jovaughn Chin-->
<html>
	<head>
		 <!--Import CSS Style Sheet-->
    	<link rel="stylesheet" type="text/css" href="./manageMaps.css">
	</head>

	<header >
		<h1>Select A Map to Manage</h1>
	</header>

			<!-- Start Gallery Html Container -->
				<?php
					require "./db.php";
		
					$result = mysqli_query($con, "SELECT * FROM maps");
					$result = mysqli_query($con,"SELECT maps.image_url, maps.id, mock_devmaster.description 
							FROM  mock_devmaster, maps
							WHERE 
					maps.developmentcode = mock_devmaster.developmentcode") 
		 			or die("ERROR: " . mysqli_error($con));
					if ($result):

					    while ($row = mysqli_fetch_assoc($result)):
					        echo("<div class='wrap'>");
					            echo("<div class='map-block'>");
					                echo("<div class='map-img'>");
					                    echo("<img src='". $row['image_url'] . "' style='width: 100; height:100' alt= Picture>");
					                echo("</div>");  // <!-- map-img -->
					         
					                echo("<div class='map-content'>");
					                echo ("<h2>" . $row['description']. " </h2>");
					                    echo("<p> Date: </p>");
					                    echo("<div class='buttons'>");
					                    echo("<a href='./editMap.php?map_id=".$row['id']."' class='edit'>Edit This Map</a>");
					                    echo("<a href='#' class='delete' id='map_id'>Delete</a>");
										echo("<a target='_new' class= 'view' href='./viewMap.php?map_id=".$row['id']."'>View Map</a>");
										echo("</div>");
					                echo("</div>"); //<!-- map-content -->
					            echo("</div> "); // <!-- map-block -->
					        echo("</div>");
					    endwhile;
					endif;
				?>
</html>

	<script>

		$('.edit').click(function(){
			 $("#portal").load( $(this).attr('href') );
			 return false;
		})	

		$(".delete").click(function(){
			var map_id = $(this).attr("id");
			var parent = $(this).parent();

			$("<div style='background-color: white;'></div>").appendTo('body')
		    .html('<div><h6>Are you sure you want to delete this map & all defined areas for it?</h6></div>')
		    .dialog({
		        modal: true,
		        title: 'Delete message',
		        zIndex: 10000,
		        autoOpen: true,
		        width: '500px',
		        resizable: false,
		        buttons: {
		            Yes: function () {
		                	parent.remove();
			
							$.post( "./deleteMap.php?map_id=" + map_id, function( data ) {
				
							});
		                $(this).dialog("close");
		            },
		            No: function () {
		                $(this).dialog("close");
		            }
		        },
		        close: function (event, ui) {
		            $(this).remove();
		        }
		    });
			

			});

	</script>