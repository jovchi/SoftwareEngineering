<!DOCTYPE HTML>
<html lang="en" >
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Manage Maps | Edit Maps</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		 <!--Import CSS Style Sheet-->
    	<link rel="stylesheet" type="text/css" href="./manageMaps.css">
		<script type="text/javascript" src="js/jquery.opacityrollover.js"></script>

		<script type="text/javascript">
	      function makeList(){
	         
	        var wrap= document.getElementByClass('wrap');
	      	wrap.style.width=100%;
	      	wrap.style.height=100%;

	      	var container= document.getElementByClass('container');
	      	container.style.width= "40em";
	      }

	      function makeGrid(){
	      	var wrap= document.getElementByClass('wrap');
	      	wrap.style.width=33.33%;
	      	wrap.style.height=33.33%;

	      	var container= document.getElementByClass('container');
	      	container.style.width= '80em';
	      }
  		</script>

	</head>
	<body>

	<header >
		<h1>Select A Map to Manage</h1>
	</header>
		<br style="clear:both"></br>

		<div class='icons'>
				<div class='icon' id='iconl' >
					<img onclick= "makeList" src="./icon/list_bullets.png"  alt="">
				</div>
				<div class='icon' id='icong'>
					<img onclick= "makeGrid" src="./icon/3x3_grid.png" alt="">
				</div>
		</div>
			<!-- Start Advanced Gallery Html Containers -->
			<div class="container">
				<?php
					require "./db.php";
		
					$result = mysqli_query($con, "SELECT * FROM maps");
					$result = mysqli_query($con,"SELECT maps.image_url, maps.id, mock_devmaster.description 
							FROM  mock_devmaster, maps
							WHERE 
					maps.developmentcode = mock_devmaster.developmentcode") 
		 			or die("ERROR: " . mysqli_error($con));
					if ($result):

					    while ($row = mysql_fetch_array($result)):
					        echo("<div class='wrap'>")
					            echo("<div class='cd-timeline-block'>");
					                echo("<div class='cd-timeline-img'>");
					                    echo("<img src='rszImage.php?id=". $row['id'] . "&thumbnail=true' alt= Picture>");
					                echo("</div> <!-- cd-timeline-img -->");
					         
					                echo("<div class='cd-timeline-content'>");
					                echo ("<h2>" . $row['description']. " </h2>");
					                    echo("<p> Last Update 9/10/14 </p>");
					                    echo("<a href='./editMap.php?map_id=".$row['id']."' class='cd-edit'>Edit This Map</a>");
					                echo("</div> <!-- cd-timeline-content -->");
					            echo("</div> <!-- cd-timeline-block -->");
					        echo("</div>");
					    endwhile;
					endif;

				?>
			</div>
	</body>
</html>

	<script>

		$('.cd-edit').click(function(){
			 $("#portal").load( $(this).attr('href') );
			 return false;
		})	

	</script>