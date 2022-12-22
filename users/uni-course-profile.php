<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../user_login.php");
}

$username = $_SESSION['username'];
$image=$_SESSION['image'];
$user_id = $_SESSION['user_id'];
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
$university=$row['university'];

$sql1 = "SELECT * FROM university WHERE university_id='$university'";
$result1 = mysqli_query($conn, $sql1);
$row1=mysqli_fetch_assoc($result1);
$uni_username=$row1['username'];
$university_name=$row1['university_name'];

$sql2 = "SELECT * from teachers where teacher_id='$teacher_id'";
$result2 = mysqli_query($conn, $sql2);
$row2=mysqli_fetch_assoc($result2);
$teacher_name = $row2['firstname']." ".$row2['lastname'];
$teacher_img = $row2['teacher_img'];

if(isset($_POST['rate_course'])){

    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $error = "";
    $cls="";

    $query = "SELECT * FROM course_rate WHERE course_id = '$course_id' AND user_id = '$user_id'";
    $query_run = mysqli_query($conn, $query);
    if(!$query_run->num_rows > 0){

                $query2 = "INSERT INTO course_rate(course_id, user_id, `rating`,`comment`)
                VALUES ('$course_id', '$user_id', '$rating','$comment')";
                $query_run2 = mysqli_query($conn, $query2);
    
                if ($query_run2) {
                    $cls="success";
                    $error = "Rating Successfully.";
                } 
                else {
                    $cls="danger";
                    $error = mysqli_error($conn);
                }
    }else{
        $query2 = "UPDATE course_rate SET`rating`='$rating',`comment`='$comment' WHERE course_id = '$course_id' AND user_id = '$user_id'";
        $query_run2 = mysqli_query($conn, $query2);

        if ($query_run2) {
            $cls="success";
            $error = "Rating Successfully.";
        } 
        else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
   
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

        .lesson:hover {
            background-color: #ececee;
        }
    </style>
</head>

<body class="vertical  light  ">
    <div class="wrapper">
        <!-- Navigation Start -->
        <?php include_once("../templates/user_header.php");?>
        <!-- Navigation end -->
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12" style="margin-bottom:20px;">

                        <div class="file-container border-top">
                            <div class="file-panel">
                                <div class="row">
                                    <div class="col container"></div>
                                </div> <!-- .file-panel -->
                                <div class="row" style="padding-top:40px;">
                                    <div class="col">
                                        <div class="alert alert-<?php echo $cls;?>">
                                            <?php 
                                            if (isset($_POST['rate_course'])){
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
                                                <span><img src="../images/teachers/<?php echo $teacher_img?>"
                                                        class="img-fluid rounded-circle" alt=""
                                                        width="40px">&nbsp;&nbsp;&nbsp;
                                                    <span class="text-dark" style="font-size: 16px;"><span
                                                            style="font-weight:600;">Course Instructor:
                                                        </span><?php echo $teacher_name?></span></span>
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
                                                <div style="padding-right:40px;">

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
                                            <?php
                                                    $sql = " SELECT * FROM course_lesson_complete WHERE lesson_id='$lesson_id' AND user_id='$user_id';";
                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result->num_rows > 0) {
                                                        $com=1;
                                                    
                                            ?>
                                            <div style="text-decoration:none;color:#222">

                                                <div class="d-flex justify-content-between"
                                                    style="padding: 20px 50px;background-color:#99ee99;">
                                                    <div class="d-flex">
                                                        <div style="padding-top:1.5rem">
                                                            <h2><?php echo $lesson_no?></h2>
                                                        </div>
                                                        <div style="padding-left:5rem;padding-top:1rem">
                                                            <h4><?php echo $lesson_title?></h4>
                                                            <p><?php echo substr($lesson_Instructions, 0, 100)?>
                                                            </p>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <?php
                                                }
                                                else{
                                                    $com=0;
                                            ?>
                                            <a href="../course-compiler.php?course_id=<?php echo $course_id?>&lesson_id=<?php echo $lesson_id?>"
                                                style="text-decoration:none;color:#222">

                                                <div class="d-flex justify-content-between lesson"
                                                    style="padding: 20px 50px;">
                                                    <div class="d-flex">
                                                        <div style="padding-top:1.5rem">
                                                            <h2><?php echo $lesson_no?></h2>
                                                        </div>
                                                        <div style="padding-left:5rem;padding-top:1rem">
                                                            <h4><?php echo $lesson_title?></h4>
                                                            <p><?php echo substr($lesson_Instructions, 0, 100)?>
                                                            </p>
                                                        </div>

                                                    </div>

                                                </div>
                                            </a>
                                            <?php
                                                        }
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
                                                <div style="padding-right:40px;">

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
                                            <?php
                                                    $sql = " SELECT * FROM course_assignment_complete WHERE assignment_id='$assignment_id' AND user_id='$user_id';";
                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result->num_rows > 0) {
                                                        $com=1;
                                                    
                                            ?>
                                            <div style="text-decoration:none;color:#222">

                                                <div class="d-flex justify-content-between"
                                                    style="padding: 20px 50px;background-color:#99ee99;">
                                                    <div class="d-flex">
                                                        <div style="padding-top:1.5rem">
                                                            <h2><?php echo $assignment_no?></h2>
                                                        </div>
                                                        <div style="padding-left:5rem;padding-top:1rem">
                                                            <h6 id="demo-<?php echo $assignment_id?>"></h6>

                                                            <h4><?php echo $assignment_title?></h4>
                                                            <p><?php echo substr($assignment_Instructions, 0, 100)?>
                                                            </p>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                            <?php
                                                }
                                                else{
                                                    $com=0;
                                            ?>
                                            <a href="../assignment-compiler.php?course_id=<?php echo $course_id?>&assignment_id=<?php echo $assignment_id?>"
                                                style="text-decoration:none;color:#222">

                                                <div class="d-flex justify-content-between assignment"
                                                    style="padding: 20px 50px;">
                                                    <div class="d-flex justify-content-between">
                                                        <div style="padding-top:1.5rem">
                                                            <h2><?php echo $assignment_no?></h2>
                                                        </div>
                                                        <div style="padding-left:5rem;padding-top:1rem">

                                                            <h4><?php echo $assignment_title?></h4>
                                                            <p><?php echo substr($assignment_Instructions, 0, 100)?>
                                                            </p>
                                                        </div>

                                                    </div>
                                                    <div class="">
                                                            Deadline : <h6 id="demo-<?php echo $assignment_id?>"></h6>
                                                        </div>
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
                                                </div>
                                            </a>
                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> <!-- .file-container -->
                    </div> <!-- .col -->
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->

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