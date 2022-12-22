<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../user_login.php");
}

$username = $_SESSION['username'];
$image=$_SESSION['image'];
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>CodeEve | All Courses</title>
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
                                <h2 class="page-title">All Courses</h2>
                            </div>
                        </div>

                        <div class="file-container border-top">
                            <div class="file-panel mt-4">
                                <div class="row my-4 pb-4">
                                    <?php

                                        $sql = "SELECT * from course where university=1";
                                        $result = mysqli_query($conn, $sql);
                                        if($result){
                                            while($row=mysqli_fetch_assoc($result)){

                                                $course_id = $row['course_id'];

                                                $sql1 = "SELECT * from course where course_id='$course_id'";
                                                $result1 = mysqli_query($conn, $sql1);
                                                $row1=mysqli_fetch_assoc($result1);

                                                $course_img = $row1['course_img'];
                                                $level = $row1['level'];
                                                $language = $row1['language'];
                                                $course_name = $row1['course_name'];
                                                $course_description = $row1['course_description'];
                                                $teacher_id = $row1['teacher_id'];
                                                $price = $row1['price'];

                                                $sql2 = "SELECT * from teachers where teacher_id='$teacher_id'";
                                                $result2 = mysqli_query($conn, $sql2);
                                                $row2=mysqli_fetch_assoc($result2);
                                                $teacher_name = $row2['firstname']." ".$row2['lastname'];
                                        ?>
                                    <a href="course-profile.php?course_id=<?php echo $course_id?>"
                                        style="text-decoration: none;color:#222">
                                        <div class="col-md-3" style="padding-bottom:20px;">
                                            <div class="card" style="width: 18rem; height:28rem;">
                                                <img src="../images/courses/<?php echo $course_img?>"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="file-info" style="margin: 0px 10px 15px 0;">
                                                            <span class="badge badge-dark text-light mr-2"
                                                                style="padding:5px;"><?php echo $level?></span>
                                                            <span class="badge badge-dark text-light mr-2"
                                                                style="padding:5px;"><?php echo $language?></span>
                                                        </div>
                                                        <div>
                                                            <span>By <?php echo $teacher_name?></span>
                                                        </div>
                                                    </div>

                                                    <h5 class="card-title"><?php echo $course_name?></h5>
                                                    <p class="card-text">
                                                        <?php echo substr($course_description, 0, 100)?>
                                                    </p>

                                                </div>
                                                <div class="card-footer">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <?php
                                                                $sql9 = "SELECT * FROM course_rate WHERE course_id = '$course_id'";
                                                                $result9 = mysqli_query($conn, $sql9);
                                                                $count = $result9->num_rows;
                                                        
                                                                $query10 = "SELECT AVG(rating) AS average FROM course_rate WHERE course_id = '$course_id'";
                                                                $result10 = mysqli_query($conn, $query10);
                                                                $row10 = mysqli_fetch_assoc($result10);
                                                                $avg = $row10['average'];
                                                            ?>
                                                            <div class="d-flex justify-content-between">
                                                                <h6><i class="fa fa-star mr-2"
                                                                        style="color:orange;"></i><?php echo round($avg,1)?>
                                                                    <small style="font-size:10px;">(<?php echo $count?>)</small></h6>
                                                                <span>
                                                                    <?php if($price==0){?>
                                                                    <h6>Free
                                                                    </h6>
                                                                    <?php }else{ ?>
                                                                    <h6><?php echo $price?>
                                                                        <small>Tk.</small></h6>
                                                                    <?php }?>
                                                                </span>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>



                                        </div> <!-- .row -->
                                    </a>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div> <!-- .file-panel -->

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