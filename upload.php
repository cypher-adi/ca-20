<?php
session_start();
include('dbconnection.php');
if(!isset($_SESSION['reg_no'])){
    header('location:index.php');
}
if(isset($_POST["submit"])) {
 $name=$_SESSION['reg_no'];
$target_dir = "img/";
$uploadOk = 1;
$imageFileType = pathinfo( basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
$target_file = $target_dir .$name.".$imageFileType";
// Check if image file is a actual image or fake image

    if(empty($_FILES["fileToUpload"]["name"])){
    echo 'please select an image';
    header('location:prof_pic.php');
}
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
 
/*if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}*/
// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
   if (file_exists($target_file)) {   
   unlink($target_file);
    } 
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $sql="UPDATE users SET img_path='$target_file',dp_status='1' WHERE reg_no='$name' ";
        if(mysqli_query($conn, $sql)){
             $info = getimagesize($target_file); 
            if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/JPEG') $image = imagecreatefromjpeg($target_file); 
            elseif ($info['mime'] == 'image/gif' || $info['mime'] == 'image/GIF') $image = imagecreatefromgif($target_file); 
            elseif ($info['mime'] == 'image/png' || $info['mime'] == 'image/PNG') $image = imagecreatefrompng($target_file); 
            elseif ($info['mime'] == 'image/jpg' || $info['mime'] == 'image/JPG') $image = imagecreatefromjpeg($target_file); 
            imagejpeg($image, $target_file, 10);
            header('location:home.php');

        }else{
            echo 'Error adding to database';
        }        
        
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
echo "<a href=\"home.php\">Go to Home</a>";
}
else {
    header('location:prof_pic.php');
}
?>
