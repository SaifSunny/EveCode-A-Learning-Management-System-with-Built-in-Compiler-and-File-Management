<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../teacher_login.php");
}

$username = $_SESSION['teachername'];
$image=$_SESSION['image'];
$teacher_id=$_SESSION['teacher_id'];

$course_id= $_POST['course_id'];

$query = "DELETE FROM course WHERE course_id='$course_id'";
$query_run = mysqli_query($conn, $query);
    
if ($query_run) {   
    header("Location: uni-courses.php");
} else {
    $cls="danger";
    $error = mysqli_error($conn);
}
   