<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../teacher_login.php");
}

$username = $_SESSION['teachername'];
$image=$_SESSION['image'];
$teacher_id=$_SESSION['teacher_id'];

$course_id= $_GET['course_id'];
$lesson_id= $_GET['lesson_id'];



    $query = "DELETE FROM course_lessons WHERE course_id='$course_id' AND lesson_id='$lesson_id'";
    $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            header("Location: uni-course-profile.php?course_id=$course_id");
        } else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
   