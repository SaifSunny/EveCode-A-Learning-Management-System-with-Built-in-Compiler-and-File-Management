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

$file_id = $_GET['file_id'];

$sql = "SELECT * FROM user_files WHERE file_id='$file_id'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$filename =$row['filename'];
$filetype =$row['filetype'];

$dir_path = getcwd();
$file_path = $dir_path."/ide"."/".$username."/";

//Check the file exists or not
if(file_exists($file_path.$filename.".".$filetype)) {

  header('Content-Description: File Transfer');
  header('Content-Disposition: attachment; filename='.basename($filename.".".$filetype));
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($file_path.$filename.".".$filetype));
  header("Content-Type: text/plain");
  readfile($file_path.$filename.".".$filetype);
  
}else{
  echo "File does not exist.";
}





?>