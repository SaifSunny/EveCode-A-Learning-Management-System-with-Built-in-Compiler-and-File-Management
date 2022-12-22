<?php
include_once("./database/config.php");

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
}

$user_id = $_SESSION['user_id'];
$image = $_SESSION['image'];
$username = $_SESSION['username'];

date_default_timezone_set('Asia/Dhaka');

$file_id = $_POST['file_id'];
$filename= strtolower($_POST['filename']);

$sql = "SELECT * FROM user_files WHERE file_id='$file_id'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
$old_name =$row['filename'];
$filetype =$row['filetype'];

$dir_path = getcwd();
$file_path = $dir_path."/ide"."/".$username."/";

if(file_exists($file_path.$filename.".".$filetype))
 { 
   echo "<script> 
   alert('A File With The Same Name Already Exists');
   window.location.href='users/my_repo.php';
   </script>";
 }
else
 {
   if(rename($file_path.$old_name.".".$filetype, $file_path.$filename.".".$filetype))
     { 
        $sql = "UPDATE user_files SET filename= '$filename' WHERE file_id='$file_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script> 
            alert('Filename Updated');
            window.location.href='users/my_repo.php';
            </script>";
        } 
        else {
            echo mysqli_error($conn);
        }
     }
     else
     {
        echo "<script> 
        alert('A File With The Same Name Already Exists');
        window.location.href='users/my_repo.php';
        </script>";
     }
  }





?>