<?php
include_once("../database/config.php");
date_default_timezone_set('Asia/Dhaka');

session_start();

if (!isset($_SESSION['uniname'])) {
    header("Location: ../university_login.php");
}

$username = $_SESSION['uniname'];
$image=$_SESSION['image'];

$course_id= $_GET['course_id'];

$sql1 = "SELECT * from course where course_id='$course_id'";
$result1 = mysqli_query($conn, $sql1);
$row=mysqli_fetch_assoc($result1);

$course_img = $row['course_img'];
$level = $row['level'];
$language = $row['language'];
$course_name = $row['course_name'];
$course_description = $row['course_description'];
$price = $row['price'];
$teacher_id = $row['teacher_id'];

$sql = "SELECT * FROM teachers WHERE teacher_id='$teacher_id'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$firstname=$row['firstname'];
$lastname=$row['lastname'];
$about_me=$row['about_me'];
$gender=$row['gender'];
$birthday=$row['birthday'];
$contact=$row['contact'];
$email=$row['email'];
$address=$row['address'];
$city=$row['city'];
$zip=$row['zip'];
$teacher_id=$row['teacher_id'];
$university=$row['university'];

$sql1 = "SELECT * FROM university WHERE university_id='$university'";
$result1 = mysqli_query($conn, $sql1);
$row1=mysqli_fetch_assoc($result1);
$uni_username=$row1['username'];
$university_name=$row1['university_name'];

if(isset($_POST['update_course'])){

    $course_description = $_POST['course_description'];
    $course_name = $_POST['course_name'];
    $level = $_POST['level'];
    $language = $_POST['language'];

    $error = "";
    $cls="";

    $query = "SELECT * FROM course WHERE course_name = '$course_name' AND teacher_id = '$teacher_id' AND level='$level'";
    $query_run = mysqli_query($conn, $query);
    if(!$query_run->num_rows > 0){
        
        // Insert record

        $query2 = "UPDATE course SET course_name = '$course_name', `level`='$level',`language`='$language', `course_description`='$course_description' WHERE course_id=$course_id";
        $query_run2 = mysqli_query($conn, $query2);
    
        if ($query_run2) {
            $cls="success";
            $error = "Course Successfully Updated.";
        } 
        else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
    
    }else{
        $cls="danger";
        $error = "Course Already Exists";
    }
   
}

if(isset($_POST['delete_course'])){

    $query = "DELETE FROM courses WHERE course_id='$course_id'";
    $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            header("Location: my-courses.php");
        } else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
   
}

if(isset($_POST['add_lesson'])){

    $lesson_no = $_POST['lesson_no'];
    $lesson_title = $_POST['lesson_title'];
    $lesson_Instructions = $_POST['lesson_Instructions'];
    $lesson_code_sample = $_POST['lesson_code_sample'];
    $lesson_output = $_POST['lesson_output'];

    $error = "";
    $cls="";

    $query = "SELECT * FROM course_lessons WHERE course_id = '$course_id' AND lesson_no = '$lesson_no'";
    $query_run = mysqli_query($conn, $query);
    if(!$query_run->num_rows > 0){
        $query = "SELECT * FROM course_lessons WHERE course_id = '$course_id' AND lesson_title = '$lesson_title'";
        $query_run = mysqli_query($conn, $query);
        if(!$query_run->num_rows > 0){

                $query2 = "INSERT INTO course_lessons(course_id, lesson_no, `lesson_Instructions`,`lesson_code_sample`, `lesson_output`,lesson_title,language)
                VALUES ('$course_id', '$lesson_no', '$lesson_Instructions','$lesson_code_sample', '$lesson_output', '$lesson_title', '$language')";
                $query_run2 = mysqli_query($conn, $query2);
    
                if ($query_run2) {
                    $cls="success";
                    $error = "Lesson Successfully Added.";
                } 
                else {
                    $cls="danger";
                    $error = mysqli_error($conn);
                }
            }
            else{
                $cls="danger";
        $error = "Lesson Title Already Exists";
            }
    }else{
        $cls="danger";
        $error = "Lesson Number Already Exists";
    }
   
}

if(isset($_POST['add_assignment'])){

    $assignment_no = $_POST['assignment_no'];
    $assignment_title = $_POST['assignment_title'];
    $assignment_Instructions = $_POST['assignment_Instructions'];
    $assignment_code_sample = $_POST['assignment_code_sample'];
    $assignment_output = $_POST['assignment_output'];
    $deadline =  $_POST['deadline_date']." ".$_POST['deadline_time'];

    $post= date('Y.m.d H:i:s');

    $error = "";
    $cls="";

    $query = "SELECT * FROM course_assignments WHERE course_id = '$course_id' AND assignment_no = '$assignment_no'";
    $query_run = mysqli_query($conn, $query);
    if(!$query_run->num_rows > 0){
        $query = "SELECT * FROM course_assignments WHERE course_id = '$course_id' AND assignment_title = '$assignment_title'";
        $query_run = mysqli_query($conn, $query);
        if(!$query_run->num_rows > 0){

                $query2 = "INSERT INTO course_assignments(course_id, assignment_no, `assignment_Instructions`,`assignment_code_sample`, `assignment_output`,assignment_title,language,post,deadline)
                VALUES ('$course_id', '$assignment_no', '$assignment_Instructions','$assignment_code_sample', '$assignment_output', '$assignment_title', '$language', '$post', '$deadline')";
                $query_run2 = mysqli_query($conn, $query2);
    
                if ($query_run2) {
                    $cls="success";
                    $error = "Assignment Successfully Added.";
                } 
                else {
                    $cls="danger";
                    $error = mysqli_error($conn);
                }
            }
            else{
                $cls="danger";
        $error = "Assignment Title Already Exists";
            }
    }else{
        $cls="danger";
        $error = "Assignment Number Already Exists";
    }
   
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>CodeEve | Course Profile</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="../dashboard/css/simplebar.css">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="../dashboard/css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="../dashboard/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="../dashboard/css/app-light.css" id="lightTheme">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        .container {
            margin: 0;
            padding: 0;
            width: 190%;
            height: 300px;
            background-image: url("../images/courses/<?php echo $course_img?>");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: 50% 50%;
        }
    </style>
</head>

<body class="vertical  light  ">
    <div class="wrapper">
        <!-- Navigation Start -->
        <?php include_once("../templates/university_header.php");?>
        <!-- Navigation end -->
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">


                        <div class="file-container border-top">
                            <div class="file-panel">
                                <div class="row">
                                    <div class="col container"></div>

                                </div> <!-- .file-panel -->

                                <div class="row" style="padding-top:40px;">
                                    <div class="col">
                                        <div class="alert alert-<?php echo $cls;?>">
                                            <?php 
                                            if (isset($_POST['update_course']) || isset($_POST['add_lesson'])||isset($_POST['add_assignment'])||isset($_POST['delete_lesson'])||isset($_POST['delete_assignment'])){
                                                echo $error;
                                            }
                                        ?>
                                        </div>
                                        
                                        <div class="file-info" style="margin: 0px 10px 15px 0;font-size:20px;">
                                            <span class="badge badge-dark text-light mr-2"
                                                style="padding:8px 20px;"><?php echo $level?></span>
                                            <span class="badge badge-dark text-light mr-2"
                                                style="padding:8px 20px;"><?php echo $language?></span>
                                        </div>
                                        <h1><?php echo $course_name?></h1>
                                        <div class="d-flex">
                                            <h4><?php echo $university_name?> (<?php echo $uni_username?>)</h4>

                                        </div>


                                        <div class="d-flex justify-content-between" style="padding-right: 40px;">
                                            <div class="d-flex justify-content-between"
                                                style="margin-top:10px;padding-bottom:20px;">
                                                <span><img src="../images/teachers/<?php echo $image?>"
                                                        class="img-fluid rounded-circle" alt=""
                                                        width="40px">&nbsp;&nbsp;&nbsp;
                                                    <span class="text-dark" style="font-size: 16px;"><span
                                                            style="font-weight:600;">Course Instructor:
                                                        </span><?php echo $firstname." ".$lastname?></span></span>
                                            </div>
                                            <div>
                                                <a href="uni-course-students.php?course_id=<?php echo $course_id?>"
                                                    class="btn btn-warning" style="font-weight:700;color:white;">Student
                                                    List</a>
                                                <a href="" class="btn btn-primary" style="font-weight:700;color:white;"
                                                    data-toggle="modal" data-target="#updateModal">Update</a>
                                                <a href="" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal"
                                                    style="font-weight:700;color:white;'">Delete</a>
                                            </div>

                                        </div>
                                        <hr>

                                        <div>
                                            <h3 style="padding-top:20px;">Course Description</h3>
                                            <div style="padding: 20px 40px 20px 20px;;">
                                                <p><?php echo $course_description?></p>
                                                <h6>Course Dificulty: <?php echo $level ?></h6>
                                                <h6>Programming language: <?php echo $language ?></h6>
                                            </div>
                                        </div>
                                        <hr>

                                        <div>
                                            <div class="d-flex justify-content-between" style="padding:20px 0;">
                                                <div>
                                                    <h3>Lessons</h3>

                                                </div>
                                                <div style="padding-right:40px;padding-bottom:20px;">
                                                    <a href="uni-lesson-stat.php?course_id=<?php echo $course_id?>"
                                                        class="btn btn-warning"
                                                        style="font-weight:700;color:white;">Student
                                                        Progress</a>
                                                    <a href="" class="btn btn-primary"
                                                        style="font-weight:700;color:white;" data-toggle="modal"
                                                        data-target="#addlesson">Add Lessons</a>

                                                </div>

                                            </div>
                                            <?php
                                                $sql5 = "SELECT * from course_lessons where course_id=$course_id";
                                                $result5 = mysqli_query($conn, $sql5);
                                                if($result5){
                                                    while($row5=mysqli_fetch_assoc($result5)){

                                                        $lesson_id = $row5['lesson_id'];

                                                        $lesson_no = $row5['lesson_no'];
                                                        $lesson_title = $row5['lesson_title'];
                                                        $lesson_Instructions = $row5['lesson_Instructions'];
                                                        $lesson_code_sample = $row5['lesson_code_sample'];
                                                        $lesson_output = $row5['lesson_output'];

                                            ?>
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex" style="padding: 10px 50px;">
                                                    <div>
                                                        <h2><?php echo $lesson_no?></h2>
                                                    </div>
                                                    <div style="padding-left:5rem;">
                                                        <h4><?php echo $lesson_title?></h4>
                                                        <p><?php echo substr($lesson_Instructions, 0, 287)?>
                                                        </p>
                                                    </div>

                                                </div>
                                                <div style="margin-right:5%;">
                                                    <a href="delete-uni-lesson.php?lesson_id=<?php echo $lesson_id?>&course_id=<?php echo $course_id?>"
                                                        class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                            <?php

                                                    }
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div>
                                            <div class="d-flex justify-content-between" style="padding:20px 0;">
                                                <div>
                                                    <h3>Assignments</h3>
 
                                                </div>
                                                <div style="padding-right:40px;padding-bottom:20px;">
                                                    <a href="uni-assignment-stat.php?course_id=<?php echo $course_id?>"
                                                        class="btn btn-warning"
                                                        style="font-weight:700;color:white;">Student
                                                        Progress</a>
                                                    <a href="" class="btn btn-primary"
                                                        style="font-weight:700;color:white;" data-toggle="modal"
                                                        data-target="#addassignment">Add Assignment</a>

                                                </div>

                                            </div>
                                            <?php
                                                $sql5 = "SELECT * from course_assignments where course_id=$course_id";
                                                $result5 = mysqli_query($conn, $sql5);
                                                if($result5){
                                                    while($row5=mysqli_fetch_assoc($result5)){

                                                        $assignment_id = $row5['assignment_id'];

                                                        $assignment_no = $row5['assignment_no'];
                                                        $assignment_title = $row5['assignment_title'];
                                                        $assignment_Instructions = $row5['assignment_Instructions'];
                                                        $assignment_code_sample = $row5['assignment_code_sample'];
                                                        $assignment_output = $row5['assignment_output'];
                                                        $deadline = $row5['deadline'];

                                            ?>
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex" style="padding: 10px 50px;">
                                                    <div>
                                                        <h2><?php echo $assignment_no?></h2>
                                                    </div>
                                                    <div style="padding-left:5rem;">
                                                        <h6 id="demo-<?php echo $assignment_id?>"></h6>
                                                        <script>
                                                            // Update the count down every 1 second
                                                            var x = setInterval(function () {
                                                                // Set the date we're counting down to
                                                                var countDownDate = new Date(
                                                                    "<?php echo $deadline?>").getTime();
                                                                // Get today's date and time
                                                                var now = new Date().getTime();

                                                                // Find the distance between now and the count down date
                                                                var distance = countDownDate - now;

                                                                // Time calculations for days, hours, minutes and seconds
                                                                var days = Math.floor(distance / (1000 * 60 *
                                                                    60 * 24));
                                                                var hours = Math.floor((distance % (1000 * 60 *
                                                                    60 * 24)) / (1000 * 60 * 60));
                                                                var minutes = Math.floor((distance % (1000 *
                                                                    60 * 60)) / (1000 * 60));
                                                                var seconds = Math.floor((distance % (1000 *
                                                                    60)) / 1000);

                                                                // Output the result in an element with id="demo"
                                                                document.getElementById(
                                                                        "demo-<?php echo $assignment_id?>")
                                                                    .innerHTML = days + "d " + hours + "h " +
                                                                    minutes + "m " + seconds + "s ";

                                                                // If the count down is over, write some text 
                                                                if (distance < 0) {
                                                                    clearInterval(x);
                                                                    document.getElementById(
                                                                            "demo-<?php echo $assignment_id?>")
                                                                        .innerHTML = "EXPIRED";
                                                                }
                                                            }, 1000);
                                                        </script>
                                                        <h4><?php echo $assignment_title?></h4>
                                                        <p><?php echo substr($assignment_Instructions, 0, 287)?>
                                                        </p>
                                                    </div>

                                                </div>

                                                <div style="margin-right:5%;">
                                                    <div>
                                                        <a href="delete-uni-assignment.php?assignment_id=<?php echo $assignment_id?>&course_id=<?php echo $course_id?>"
                                                            class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php

                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .file-container -->
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                </div> <!-- .container-fluid -->



                <!-- Update modal -->
                <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="varyModalLabel">Update Course</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" method="POST" enctype='multipart/form-data'>
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>level <span style="color:red">*</span></label>
                                                    <select class="form-control" name="level" id="level" required>
                                                        <option><?php echo $level?></option>
                                                        <option value="Beginner">Beginner</option>
                                                        <option value="Intermediate">Intermediate</option>
                                                        <option value="Expert">Expert</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Language <span style="color:red">*</span></label>
                                                    <select class="form-control" name="language" id="language" required>
                                                        <option><?php echo $language?></option>
                                                        <option value="C">C</option>
                                                        <option value="C++">C++</option>
                                                        <option value="PHP">PHP</option>
                                                        <option value="JavaScript">JavaScript</option>
                                                        <option value="Python">Python</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Course Name <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="course_name"
                                                        id="course_name" placeholder="Course Name"
                                                        value="<?php echo $course_name?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Enrollment Fee <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="price" id="price"
                                                        value="<?php echo $price?>" placeholder="Enrollment Fee"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Course Description <span style="color:red">*</span></label>
                                                    <textarea class="form-control" name="course_description" rows="5"
                                                        id="course_description" placeholder="Course Description"
                                                        required><?php echo $course_description?></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="submit" name="update_course" class="btn mb-2 btn-primary">Update
                                        course</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- add modal -->

                <!-- Delete modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
                    aria-hidden="true" style="padding-top: 100px;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="varyModalLabel">
                                    Delete Course</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="delete-uni-course.php" method="POST">
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="course_id" name="course_id"
                                            value="<?php echo $course_id?>">
                                    </div>
                                    <div class="form-group">
                                        <h5>Are You Sure You Want To Delete this
                                            course.</h5>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-end">
                                    <button type="submit" name="delete_course"
                                        class="btn mb-2 btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- Delete modal -->


                <!-- Add lesson -->
                <div class="modal fade" id="addlesson" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="varyModalLabel">Add Lesson</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" method="POST" enctype='multipart/form-data'>
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Lesson No. <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="lesson_no"
                                                        id="lesson_no" placeholder="Lesson No." required>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Lesson Title <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="lesson_title"
                                                        id="lesson_title" placeholder="Lesson title" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Lesson Output <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="lesson_output"
                                                        id="lesson_output" placeholder="Lesson Output" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Lesson Instructions <span style="color:red">*</span></label>
                                                    <textarea class="form-control" name="lesson_Instructions" rows="5"
                                                        id="lesson_Instructions" placeholder="Lesson Instructions"
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Code Sample <span style="color:red">*</span></label>
                                                    <textarea class="form-control" name="lesson_code_sample" rows="5"
                                                        id="lesson_code_sample" placeholder="Code Sample"
                                                        required></textarea>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="submit" name="add_lesson" class="btn mb-2 btn-primary">Add Lesson
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- add lesson -->

                <!-- Add assignment -->
                <div class="modal fade" id="addassignment" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="varyModalLabel">Add Assignment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" method="POST" enctype='multipart/form-data'>
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Assignment No. <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="assignment_no"
                                                        id="assignment_no" placeholder="Assignment No." required>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Assignemnt title <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="assignment_title"
                                                        id="assignment_title" placeholder="Assignment title" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Assignment Output <span style="color:red">*</span></label>
                                                    <input type="text" class="form-control" name="assignment_output"
                                                        id="assignment_output" placeholder="Assignment Output" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Assignment Deadline <span style="color:red">*</span></label>
                                                    <div class="d-flex">
                                                        <input type="date" class="form-control" name="deadline_date"
                                                            id="deadline_date" required>
                                                        <input type="time" class="form-control" name="deadline_time"
                                                            id="deadline_time" required>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Assignment Instructions <span
                                                            style="color:red">*</span></label>
                                                    <textarea class="form-control" name="assignment_Instructions"
                                                        rows="5" id="assignment_Instructions"
                                                        placeholder="Assignment Instructions" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Code Sample <span style="color:red">*</span></label>
                                                    <textarea class="form-control" name="assignment_code_sample"
                                                        rows="5" id="assignment_code_sample" placeholder="Code Sample"
                                                        required></textarea>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="submit" name="add_assignment" class="btn mb-2 btn-primary">Add
                                        Assignment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- add assignment -->

                <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog"
                    aria-labelledby="defaultModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="list-group list-group-flush my-n3">
                                    <div class="list-group-item bg-transparent">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="fe fe-box fe-24"></span>
                                            </div>
                                            <div class="col">
                                                <small><strong>Package has uploaded successfull</strong></small>
                                                <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                                                <small class="badge badge-pill badge-light text-muted">1m ago</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item bg-transparent">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="fe fe-download fe-24"></span>
                                            </div>
                                            <div class="col">
                                                <small><strong>Widgets are updated successfull</strong></small>
                                                <div class="my-0 text-muted small">Just create new layout Index, form,
                                                    table
                                                </div>
                                                <small class="badge badge-pill badge-light text-muted">2m ago</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item bg-transparent">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="fe fe-inbox fe-24"></span>
                                            </div>
                                            <div class="col">
                                                <small><strong>Notifications have been sent</strong></small>
                                                <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus
                                                    commodo
                                                </div>
                                                <small class="badge badge-pill badge-light text-muted">30m ago</small>
                                            </div>
                                        </div> <!-- / .row -->
                                    </div>
                                    <div class="list-group-item bg-transparent">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="fe fe-link fe-24"></span>
                                            </div>
                                            <div class="col">
                                                <small><strong>Link was attached to menu</strong></small>
                                                <div class="my-0 text-muted small">New layout has been attached to the
                                                    menu
                                                </div>
                                                <small class="badge badge-pill badge-light text-muted">1h ago</small>
                                            </div>
                                        </div>
                                    </div> <!-- / .row -->
                                </div> <!-- / .list-group -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear
                                    All</button>
                            </div>
                        </div>
                    </div>
                </div>

        </main> <!-- main -->
    </div> <!-- .wrapper -->
    <script src="../dashboard/js/jquery.min.js"></script>
    <script src="../dashboard/js/popper.min.js"></script>
    <script src="../dashboard/js/moment.min.js"></script>
    <script src="../dashboard/js/bootstrap.min.js"></script>
    <script src="../dashboard/js/simplebar.min.js"></script>
    <script src='../dashboard/js/daterangepicker.js'></script>
    <script src='../dashboard/js/jquery.stickOnScroll.js'></script>
    <script src="../dashboard/js/tinycolor-min.js"></script>
    <script src="../dashboard/js/config.js"></script>
    <script src="../dashboard/js/d3.min.js"></script>
    <script src="../dashboard/js/topojson.min.js"></script>
    <script src="../dashboard/js/datamaps.all.min.js"></script>
    <script src="../dashboard/js/datamaps-zoomto.js"></script>
    <script src="../dashboard/js/datamaps.custom.js"></script>
    <script src="../dashboard/js/Chart.min.js"></script>
    <script src="../dashboard/js/gauge.min.js"></script>
    <script src="../dashboard/js/jquery.sparkline.min.js"></script>
    <script src="../dashboard/js/apexcharts.min.js"></script>
    <script src="../dashboard/js/apexcharts.custom.js"></script>
    <script src="../dashboard/js/apps.js"></script>


</body>

</html>