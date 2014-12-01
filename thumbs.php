
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