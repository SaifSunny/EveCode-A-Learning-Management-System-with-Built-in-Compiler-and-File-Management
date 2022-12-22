<?php
include_once("./database/config.php");

session_start();

if (!isset($_SESSION['teachername'])) {
    header("Location: teacher_login.php");
}

$teacher_id = $_SESSION['teacher_id'];
$image = $_SESSION['image'];
$username = $_SESSION['username'];

date_default_timezone_set('Asia/Dhaka');

$file_id = $_POST['file_id'];

$sql = "SELECT * FROM teacher_files WHERE file_id='$file_id'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$filename =$row['filename'];
$filetype =$row['filetype'];

$dir_path = getcwd();
$file_path = $dir_path."/ide"."/".$username."/";

if(!file_exists($file_path.$filename.".".$filetype))
 { 
   echo "<script> 
   alert('No Such File Exists');
   window.location.href='teachers/my_repo.php';
   </script>";
 }
else
 {
   if(unlink($file_path.$filename.".".$filetype))
     { 
        $sql = "DELETE FROM teacher_files WHERE file_id='$file_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script> 
            alert('File DELETED');
            window.location.href='teachers/my_repo.php';
            </script>";
        } 
        else {
            echo mysqli_error($conn);
        }
     }
     else
     {
        echo "<script> 
        alert('Cannot Delete the File');
        window.location.href='teachers/my_repo.php';
        </script>";
     }
  }





?>