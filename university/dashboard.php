<?php
include_once("../database/config.php");

session_start();
$username = $_SESSION['uniname'];

if (!isset($_SESSION['uniname'])) {
    header("Location: ../university_login.php");
}

$sql = "SELECT * FROM university WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$img=$row['university_img'];

$_SESSION['image'] = $img;
$_SESSION['university_id'] = $row['university_id'];
$_SESSION['username'] = $row['username'];
$_SESSION['sub'] = $row['sub'];

$university_id = $_SESSION['university_id'];

function folderSize($dir){
    $count_size = 0;
    $count = 0;
    $dir_array = scandir($dir);
    foreach($dir_array as $key=>$filename){
        if($filename!=".." && $filename!="."){
            if(is_dir($dir."/".$filename)){
                $new_foldersize = foldersize($dir."/".$filename);
                $count_size = $count_size+ $new_foldersize;
            }else if(is_file($dir."/".$filename)){
                $count_size = $count_size + filesize($dir."/".$filename);
                $count++;
            }
        }
    }
    return $count_size;
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
    <title>CodeEve | University Dashboard</title>
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
        <?php include_once("../templates/university_header.php");?>
        <!-- Navigation end -->
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row align-items-center my-3">
                            <div class="col">
                                <h2 class="page-title">Dashboard</h2>
                            </div>
                        </div>

                        <div class="file-container border-top">
                            <div class="file-panel mt-4">

                                <div class="row align-items-center mb-4">
                                    <div class="col">
                                        <h3>System Details</h3>
                                    </div>
                                </div>
                                <!-- widgets -->
                                <div class="row my-4">
                                    <div class="col-md-4">
                                        <div class="card shadow mb-6">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <p class="mb-1" style="font-size:16px;">Students</p>
                                                        <?php
                                                            $sql = "SELECT * FROM course WHERE `university`='$university_id'";
                                                            $result = mysqli_query($conn, $sql);
                                                            if($result){
                                                            while($row=mysqli_fetch_assoc($result)){
                                                                
                                                                $course_id=$row['course_id'];

                                                                $sql1 = "SELECT * from course_students where course_id=$course_id";
                                                                $result1 = mysqli_query($conn, $sql1);
                                                                $row1=mysqli_fetch_assoc($result1);

                                                                $user_id=$row1['user_id'];

                                                                $sql2 = "SELECT * from users where user_id=$user_id";
                                                                $result2 = mysqli_query($conn, $sql2);                                                            
                                                                }
                                                                $count = $result2->num_rows;
                                                        }
                                                        ?>
                                                        <h3 class="card-title mb-0"><?php echo $count?></h3>

                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <span class="fa fa-users" style="font-size:30px;"></span>
                                                    </div>
                                                </div> <!-- /. row -->
                                            </div> <!-- /. card-body -->
                                        </div> <!-- /. card -->
                                    </div> <!-- /. col -->
                                    <div class="col-md-4">
                                        <div class="card shadow mb-6">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <p class="mb-1" style="font-size:16px;">Teachers</p>
                                                        <?php
                                                            $sql = "SELECT * from teachers where university=$university_id";
                                                            $result = mysqli_query($conn, $sql);
                                                            $count = $result->num_rows;
                                                        ?>
                                                        <h3 class="card-title mb-0"><?php echo $count?></h3>

                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <span class="fa fa-user-graduate"
                                                            style="font-size:30px;"></span>
                                                    </div>
                                                </div> <!-- /. row -->
                                            </div> <!-- /. card-body -->
                                        </div> <!-- /. card -->
                                    </div> <!-- /. col -->

                                    <div class="col-md-4">
                                        <div class="card shadow mb-6">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <p class="mb-1" style="font-size:16px;">Courses</p>
                                                        <?php
                                                            $sql = "SELECT * from course where university=$university_id";
                                                            $result = mysqli_query($conn, $sql);
                                                            $count = $result->num_rows;
                                                        ?>
                                                        <h3 class="card-title mb-0"><?php echo $count?></h3>

                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <span class="fa fa-book" style="font-size:30px;"></span>
                                                    </div>
                                                </div> <!-- /. row -->
                                            </div> <!-- /. card-body -->
                                        </div> <!-- /. card -->
                                    </div> <!-- /. col -->
                                </div> <!-- end section -->
                                <hr class="my-4">
                                <div class="row">
                                    <!-- Recent Activity -->
                                    <div class="col-md-12 col-lg-5 mb-4">
                                        <div class="card timeline shadow">
                                            <div class="card-header">
                                                <strong class="card-title">Temporary User Files</strong>
                                            </div>
                                            <div class="card-body" data-simplebar
                                                style="height:355px;text-align:center;padding-top:2.5rem;">
                                                <h1 class="text-uppercase  mb-4" style="font-size:60px;"><i
                                                        class="fa fa-file"></i></h1>
                                                <?php
                                                    $size=folderSize("C:/xampp/htdocs/EveCode/ide/$username");
                                                    if($size < 1024) {
                                                ?>
                                                <h1 class="text-uppercase  mb-4"><?php echo $size." Bytes"?></h1>
                                                <?php
                                                    }else if($size < 1024000) {
                                                ?>
                                                <h1 class="text-uppercase  mb-4"><?php echo round($size,1)." KB"?></h1>
                                                <?php
                                                    }else {
                                                ?>
                                                <h1 class="text-uppercase mb-4"><?php echo  round($size,1). "MB"?></h1>
                                                <?php
                                                    }
                                                ?>
                                                <div class="pb-3 timeline-item">
                                                    <div class="pl-5">
                                                        <div class="mb-1" style="font-size:18px;">

                                                            <?php
                                                                $dir_path ="C:/xampp/htdocs/EveCode/ide/$username/temp";
                                                                $num = count(glob($dir_path . "/*"));
                                                                
                                                            ?>
                                                            <strong><?php echo $num?></strong>
                                                            <span class="text-muted small mx-2"
                                                                style="font-size:18px;">Temporary files are on the
                                                                server.Please clear them to avoid system lagging.</span>
                                                        </div>

                                                        </p>
                                                    </div>
                                                    <a href="clear_system.php" class="btn btn-primary"><i
                                                            class="fa fa-trash"></i> Clear System Files</a>
                                                </div>

                                            </div> <!-- / .card-body -->
                                        </div> <!-- / .card -->
                                    </div> <!-- / .col-md-6 -->
                                    <!-- Striped rows -->
                                    <div class="col-md-12 col-lg-7">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <strong class="card-title">Recently Joined</strong>
                                                <a class="float-right small text-muted" href="#!">View all</a>
                                            </div>
                                            <div class="card-body my-n2"
                                                style="height:370px; overflow-y: auto; overflow-x: hidden;">
                                                <table class="table table-striped table-hover table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>Profile</th>
                                                            <th>Name</th>
                                                            <th>Gender</th>
                                                            <th>Email</th>
                                                            <th>Course</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $sql = "SELECT * FROM course WHERE `university`='$university_id'";
                                                            $result = mysqli_query($conn, $sql);
                                                            if($result){
                                                                while($row=mysqli_fetch_assoc($result)){
                                                                                                                        
                                                                $course_id=$row['course_id'];
                                                                $course_name=$row['course_name'];
                                                            
                                                                $sql1 = "SELECT * from course_students where course_id=$course_id";
                                                                $result1 = mysqli_query($conn, $sql1);
                                                                $row1=mysqli_fetch_assoc($result1);
                                                            
                                                                $user_id=$row1['user_id'];
                                                            
                                                                $sql2 = "SELECT * from users where user_id=$user_id";
                                                                $result2 = mysqli_query($conn, $sql2);  
                                                                $row2=mysqli_fetch_assoc($result2);

                                                                $name=$row2['firstname']." ".$row2['lastname'];
                                                                $email=$row2['email'];
                                                                $user_img=$row2['user_img'];
                                                                $gender=$row2['gender'];

                                                        ?>
                                                        <tr>
                                                            <td><img src="<?php echo "../images/users/".$user_img?>" alt=""
                                                                    width="50"></td>
                                                            <th scope="col"><?php echo $name?></th>
                                                            <td><?php echo $gender?></td>
                                                            <td><?php echo $email?></td>
                                                            <td><?php echo $course_name?></td>
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


</body>

</html>