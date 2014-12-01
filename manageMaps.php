<!doctype html>
<html lang="en" >
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Manage Maps | Edit Maps</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script type="text/javascript" src="js/jquery.opacityrollover.js"></script>
		<!-- We only want the thunbnails to display when javascript is disabled -->
		<script type="text/javascript">
			document.write('<style>.noscript { display: none; }</style>');
		</script>

		<style type="text/css">

		
		div {
			overflow: hidden;
		}
		body {
		  font-size: 100%;
		  font-family: "Droid Serif", serif;
		  color:#101010 ;
		  background-color: #FFFFFF ;
		  text-align: center;
		}

		a {
		  padding: .8em 1em;

		  text-decoration: none;
		  font-family: "Open Sans", sans-serif;
		  margin-left: 25%;
		  margin-right: 25%;
		  font-size: .8125em;
		  background: #383838;
		  border-radius: 0.25em;
		}

		img {
		  top: 0;
		  bottom: 0;
		  width: 100px;
		  min-height:100px;
		}

		header{
			text-align: left;
		}

		h1, h2 {
		  font-family: "Open Sans", sans-serif;
		  font-weight: bold;
		}

		.wrap{
			display: block;
			margin-bottom: 20px;
			position: relative;
		    float: left;
		    width: 33.33%;
		    height: 33.33%;
		}

		.contain{
			background:	#E0E0E0 ; 
			border: 5px solid #a1a1a1;
			border-radius: 0.25em;
			padding: 10px;
			margin: 0 auto;
			width: 80em;
			text-align: left;
			overflow:hidden;
			height: 100%;
		}
		.cd-timeline-block {
			margin: 2em 0;
			border-radius: 0.25em;
			width: 400px;
			height: 100px;
			border: 2px solid #a1a1a1;
			border-radius: 0.25em;
		}
		.cd-timeline-block:after {
		  content: "";
		  display: table;
		  clear: both;
		}
		.cd-timeline-block:first-child {
  			margin-top: 0;
  		}
  		.cd-timeline-block:last-child {
		  margin-bottom: 0;
		}
		
		.cd-timeline-content {
		  float: left;
		  display: block;
		  width: 300px;
		  height: 100px;
		  background: white;
		}
		.cd-timeline-content h2 {
		  margin-left: 10px;
		  margin-bottom: 2px;
		  margin-top: 10px;
		  color: #303e49;
		}
		.cd-timeline-content p, .cd-timeline-content .cd-edit, .cd-timeline-content {
		  font-size: 0.8125rem;
		}
		.cd-timeline-content .cd-edit, .cd-timeline-content {
		  display: inline-block;
		}
		.cd-timeline-content p {
		  margin-left: 10px;
		  margin-top: 0;
		  margin-bottom: 0;
		  line-height: 1.6;
		}
		.cd-timeline-content .cd-edit {
		  color: white;
		}
		

		.cd-timeline-img {
		  float: left;
		  width: 100px; 
		  min-height: 100px;
		}
		.cd-timeline-img img {
		  display: block;
		}
		</style>

	</head>
	<body>

	<header >
		<h1>Select A Map to Manage</h1>
	</header>
		<br style="clear:both"></br>
			<!-- Start Advanced Gallery Html Containers -->
			<div class="contain">
				<?php
					include "./db.php"; //Connect to database.

					$sql = "SELECT * FROM maps, mock_devmaster";
					$result = mysql_query($sql) or exit("QUERY FAILED!");
					if ($result):
					    while ($row = mysql_fetch_array($result)):
					        echo("<div class='wrap'>")
					            echo("<div class='cd-timeline-block'>");
					                echo("<div class='cd-timeline-img'>");
					                    echo("<img src='rszImage.php?map_id=". $row['maps.id'] . "&thumbnail=true' alt= Picture>");
					                echo("</div> <!-- cd-timeline-img -->");
					         
					                echo("<div class='cd-timeline-content'>");
					                echo ("<h2>" . $row['mock_devmaster.(maps.developmentcode).description']." </h2>");
					                    echo("<p> Last Update 9/10/14 </p>");
					                    echo("<a href="" class='cd-edit'>Edit This Map</a>");
					                echo("</div> <!-- cd-timeline-content -->");
					            echo("</div> <!-- cd-timeline-block -->");
					        echo("</div>");
					    endwhile;
					endif;

				?>
				
				<script>

				$('a.cd-edit').click(function(){
					 $("#portal").load("editMap.php");
				})	

				</script>
			</div>
	</body>
</html>