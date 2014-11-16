<!DOCTYPE HTML>
    <html>
    <body>
        <!--Author: Richard Cerone-->
        <!--Title-->
        <button id="editMap">Edit Map</button>
        <h1>Upload A New Map</h1>
        <?php
            include "./db.php"; //Connect to database.
            
            //Get map names.
            $result = mysqli_query($con, "SELECT developmentcode, description FROM mock_devmaster");
            echo "<p>Select Developemt:<p>";
            echo "<select>"; //Create drop down.
            while($row = mysqli_fetch_assoc($result)) //Check if database is empty.
            {
                //Fill drop down with map names from the database.
                echo "<option>".$row['developmentcode']." ".$row['description']."</option> ";
            }
            echo "</select>"; //end drop down.
        ?>
        <!--File upload form-->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <p>Select image to upload:</p>
            <input type="file" name="file" id="file"><br>
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </body>
    </html>
    <script>
    $("#editMap").click(function() 
            {
                $("#portal").load("editMap.php"); //Load updateMap.php into portal.
            });
    </script>