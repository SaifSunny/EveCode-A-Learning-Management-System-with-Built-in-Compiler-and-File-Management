<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../user_login.php");
}

$username = $_SESSION['username'];
$image=$_SESSION['image'];
$user_id=$_SESSION['user_id'];

$course_id= $_GET['course_id'];

$sql1 = "SELECT * from course where course_id='$course_id'";
$result1 = mysqli_query($conn, $sql1);
$row=mysqli_fetch_assoc($result1);

$course_img = $row['course_img'];
$level = $row['level'];
$language = $row['language'];
$course_name = $row['course_name'];
$course_description = $row['course_description'];
$teacher_id = $row['teacher_id'];
$price = $row['price'];





$sql = "SELECT * FROM course_students WHERE course_id='$course_id' And user_id='$user_id'";
$result = mysqli_query($conn, $sql);

if (!$result->num_rows > 0) {


    $sql = "INSERT INTO course_students(`user_id`, `course_id`) VALUES ('$user_id', '$course_id')";
    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: dashboard.php");
    }else{
        echo mysqli_error($conn);
    }
            

} else {
        echo "Already Enrolled In the Course.";

}



?>

