<?php
    //Author: Richard Cerone
    $targetDir = "map_images/"; //Directory where file will be uploaded.
    $targetFile = $targetDir . basename($_FILES["file"]["name"]); //File to be uploaded.
    echo "targetFile: ".$targetFile;
    $uploadOk = 1; //Upload status: 1 means OK, 0 means error.
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));//Grabs file type.
    //Check if image file is a actual image or fake image
    if(isset($_POST["submit"]))
    {
        echo "tmp_name: ".$_FILES["file"]["tmp_name"];
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false)
        {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        }
        else
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    //Check if file already exists.
    if(file_exists($targetFile))
    {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    //Check file size.
    if($_FILES["file"]["size"] > 65465456000)
    {
        echo "Sorry, your file was not uploaded too big.";
        $uploadOk = 0;
    }
    //Check file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
    {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = 0;
    }
    //Check if $uploadOk is set to 0.
    if($uploadOk == 0)
    {
        echo "Sorry, your file was not uploaded.uploadOk = 0";
    }
    //If everything is OK, try to upload file.
    else
    {
        if(move_uploaded_file($_FILES["file"]["tmp_name"],$targetFile))
        {
            echo "The file ". basename($_FILES["file"]["name"]). " = has been uploaded.";
        }
        else
        {
            echo "Sorry, there was an error uploading your file. did not move file";
        }
    }
?>