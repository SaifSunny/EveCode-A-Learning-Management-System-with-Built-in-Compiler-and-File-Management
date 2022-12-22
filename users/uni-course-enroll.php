<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../user_login.php");
}

$user_id=$_SESSION['user_id'];
$code= $_POST['code'];

$sql1 = "SELECT * from course where joincode='$code'";
$result1 = mysqli_query($conn, $sql1);
$row=mysqli_fetch_assoc($result1);

$course_id = $row['course_id'];



$sql = "SELECT * FROM course_students WHERE course_id='$course_id' And user_id='$user_id'";
$result = mysqli_query($conn, $sql);

if (!$result->num_rows > 0) {


    $sql = "INSERT INTO course_students(`user_id`, `course_id`) VALUES ('$user_id', '$course_id')";
    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: my-classes.php");
    }else{
        echo mysqli_error($conn);
    }
            

} else {
    echo "<script> alert('Already Enrolled In the Course.');
    window.location.href='dashboard.php';</script>";

}



?>

