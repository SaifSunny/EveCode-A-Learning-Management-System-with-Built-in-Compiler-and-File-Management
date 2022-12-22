<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../user_login.php");
}

$username = $_SESSION['username'];
$image=$_SESSION['image'];

$sql = "SELECT * FROM users WHERE username='$username'";
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
$user_id=$row['user_id'];

?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>CodeEve | My Assignments</title>
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
    <link rel="stylesheet" href="../dashboard/css/app-dark.css" id="darkTheme" disabled>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>

<body class="vertical  light  ">
    <div class="wrapper">
        <!-- Navigation Start -->
        <?php include_once("../templates/user_header.php");?>
        <!-- Navigation end -->
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row align-items-center my-3">
                            <div class="col">
                                <h2 class="page-title">My Grades</h2>

                            </div>
                        </div>

                        <div class="user-container border-top">
                            <div class="user-panel mt-4">
                                <div class="row">
                                    <!-- Striped rows -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card shadow">
                                            <div class="card-body my-n2">

                                                <table class="table table-striped table-borderless"
                                                    style="text-align:center;">
                                                    <tbody>
                                                        <thead>
                                                            <tr>
                                                                <th>Course Profile</th>
                                                                <th>Course Title</th>
                                                                <th>Assignment Title</th>
                                                                <th>Assignment Submited</th>
                                                                <th>Assignment Deadline</th>
                                                                <th>Marks</th>
                                                            </tr>
                                                        </thead>
                                                        <?php 
                                                            $sql1 = "SELECT * FROM `course_assignments`join `course_assignment_complete` on course_assignments.assignment_id=course_assignment_complete.assignment_id JOIN course on course_assignments.course_id=course.course_id where user_id = $user_id";
                                                            $result1 = mysqli_query($conn, $sql1);
                                                                if($result1){
                                                                    while($row1=mysqli_fetch_assoc($result1)){

                                                                   $assignment_id=$row1['assignment_id'];     
                                                                   $assignment_no=$row1['assignment_no'];     
                                                                   $assignment_title=$row1['assignment_title'];     
                                                                   $deadline=$row1['deadline'];     
                                                                   $submit=$row1['submit'];     
                                                                   $post=$row1['post'];     
                                                                    $course_name=$row1['course_name'];
                                                                    $language=$row1['language'];
                                                                    $teacher_id=$row1['teacher_id'];
                                                                    $course_img=$row1['course_img'];
                                                                    $course_id=$row1['course_id'];

                                                        ?>
                                                        <tr style="color:#222;">
                                                            <td><img src="../images/courses/<?php echo $course_img?>"
                                                                    alt="" width="180px"></td>

                                                            <td>
                                                                <h5>
                                                                    <a href="uni-course-profile.php?course_id=<?php echo $course_id?>"
                                                                        style="text-decoration:none;color:#222">
                                                                        <?php echo $course_name?></h5> </a>
                                                            </td>

                                                            <td>
                                                                <h6><?php echo $assignment_title?></h6>
                                                            </td>


                                                            <td>
                                                                <h6><?php echo $submit?></h6>
                                                            </td>
                                                            <td>
                                                                <h6><?php echo $deadline?></h6>
                                                            </td>
                                                            
                                                            <td>
                                                                <?php
                                                                if($submit){
                                                                    if($submit<=$deadline){
                                                                        $marks=100;
                                                                    }else{
                                                                        $marks=70;
                                                                    }
                                                                }else{
                                                                    $marks=0;
                                                                }
                                                                ?>
                                                                <h6><?php echo $marks?></h6>
                                                            </td>
                                                        </tr>

                                                        <?php        
                                                                        }
                                                                    }
                                                                
                                                            ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> <!-- Striped rows -->
                                </div> <!-- .row-->
                            </div> <!-- .user-panel -->

                        </div> <!-- .user-container -->
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
                                            <div class="my-0 text-muted small">Just create new layout Index, form, table
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
                                            <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo
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
                                            <div class="my-0 text-muted small">New layout has been attached to the menu
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



    </script>
</body>

</html>