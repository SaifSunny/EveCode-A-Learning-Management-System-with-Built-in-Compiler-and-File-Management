<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['uniname'])) {
    header("Location: ../university_login.php");
}
$course_id= $_GET['course_id'];
$assignment_id= $_GET['assignment_id'];



    $query = "DELETE FROM course_assignments WHERE course_id='$course_id' AND assignment_id='$assignment_id'";
    $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            header("Location: uni-course-profile.php?course_id=$course_id");
        } else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
   