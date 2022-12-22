<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['uniname'])) {
    header("Location: ../university_login.php");
}

$course_id= $_POST['course_id'];

$query = "DELETE FROM course WHERE course_id='$course_id'";
$query_run = mysqli_query($conn, $query);
    
if ($query_run) {   
    header("Location: courses.php");
} else {
    $cls="danger";
    $error = mysqli_error($conn);
}
   