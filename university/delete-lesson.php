<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['uniname'])) {
    header("Location: ../university_login.php");
}

$course_id= $_GET['course_id'];
$lesson_id= $_GET['lesson_id'];



    $query = "DELETE FROM course_lessons WHERE course_id='$course_id' AND lesson_id='$lesson_id'";
    $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            header("Location: course-profile.php?course_id=$course_id");
        } else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
   