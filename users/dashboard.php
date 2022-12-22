<?php
include_once("../database/config.php");

session_start();
$username = $_SESSION['username'];

if (!isset($_SESSION['username'])) {
    header("Location: ../user_login.php");
}

$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$img=$row['user_img'];

$_SESSION['image'] = $img;
$_SESSION['user_id'] = $row['user_id'];
$_SESSION['username'] = $row['username'];

$user_id = $_SESSION['user_id'];

?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>CodeEve | User Dashboard</title>
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
                                <h2 class="page-title">Dashboard</h2>
                            </div>
                        </div>

                        <div class="file-container border-top">
                            <div class="file-panel mt-4">

                                <div class="row align-items-center mb-4">
                                    <div class="col">
                                        <h3>Recent Repos</h3>
                                    </div>

                                    <div class="col-auto">
                                        <button type="button" class="btn btn-lg btn-primary" data-toggle="modal"
                                            data-target="#eventModal"><span
                                                class="fe fe-plus fe-16 mr-3"></span>New</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <table>
                                        <tbody class="d-flex">
                                            <?php 
                                                $sql = "SELECT * FROM user_files WHERE user_id = '$user_id' ORDER BY file_id DESC LIMIT 4";
                                                $result = mysqli_query($conn, $sql);
                                                if($result){
                                                    while($row=mysqli_fetch_assoc($result)){
                                                    
                                                        $file_id =$row['file_id'];
                                                        $filename =$row['filename'];
                                                        $filetype =$row['filetype'];
                                                        $created =$row['created'];
 

                                                        $icon = "";
                                                        $com_lang = "";
                                                        
                                                        if($filetype=="c"){
                                                            $icon = "c-lang.png";
                                                        }
                                                        if($filetype=="cpp"){
                                                            $icon = "cpp.png";
                                                        }
                                                        if($filetype=="python"){
                                                            $icon = "python.png";
                                                        }
                                                        if($filetype=="php"){
                                                            $icon = "php.png";
                                                        }
                                                        if($filetype=="node.js"){
                                                            $icon = "node.png";
                                                        }

                                            ?>

                                            <tr>
                                                <td style="display:none;">

                                                    <p><?php echo $file_id?></p>

                                                </td>
                                                <td class="col-md-6 col-lg-4">
                                                    <div class="card shadow mb-4">
                                                        <div class="card-body file-list">
                                                            <div class="d-flex align-items-center">

                                                                <div class="circle circle-md ">
                                                                    <a href=""><img
                                                                            src="../images/icons/<?php echo $icon?>"
                                                                            width="100%" alt=""></a>
                                                                </div>
                                                                <div class="flex-fill ml-4 fname">
                                                                    <a
                                                                        href="../compiler.php?file_id=<?php echo $file_id?>"><strong><?php echo $filename?>.<?php echo $filetype?></strong></a><br />
                                                                    <span class="badge badge-light text-muted">Created
                                                                        Date:
                                                                        <?php echo $created ?></span>
                                                                </div>
                                                                <div class="file-action">
                                                                    <button type="button"
                                                                        class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                    </button>
                                                                    <div class="dropdown-menu m-2">
                                                                        <a class="dropdown-item"
                                                                            href="../compiler.php?file_id=<?php echo $file_id?>"><i
                                                                                class="fe fe-edit-3 fe-12 mr-4"></i>Edit
                                                                            Repo</a>
                                                                        <a class="dropdown-item deletebtn" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#deleteModal"><i
                                                                                class="fe fe-delete fe-12 mr-4"></i>Delete</a>
                                                                        <a class="dropdown-item"
                                                                            href="../download-repo.php?file_id=<?php echo $file_id?>"><i
                                                                                class="fe fe-download fe-12 mr-4"></i>Download</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <!-- .card-body -->
                                                    </div> <!-- .col -->
                                                </td>
                                            </tr>
                                            <!-- Delete modal -->
                                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                                aria-labelledby="eventModalLabel" aria-hidden="true"
                                                style="padding-top: 100px;">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="varyModalLabel">Delete
                                                                Repository</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="../delete-repo.php" method="POST">
                                                            <div class="modal-body p-4">
                                                                <div class="form-group">
                                                                    <input type="hidden" class="form-control"
                                                                        id="delete_id" name="file_id">
                                                                </div>

                                                                <div class="form-group">
                                                                    <h5>Are You Sure You Want To Delete this File.</h5>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-end">
                                                                <button type="submit" name="submit"
                                                                    class="btn mb-2 btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> <!-- Delete modal -->
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!-- .row -->
                                <hr class="my-4">
                                <h4 class="mb-3">My Courses</h4>
                                <div class="row my-4 pb-4">
                                    <?php

                                    $sql5 = "SELECT * from course_students where user_id=$user_id LIMIT 3";
                                    $result5 = mysqli_query($conn, $sql5);
                                    if($result5){
                                        while($row5=mysqli_fetch_assoc($result5)){

                                            $course_id = $row5['course_id'];

                                            $sql6 = "SELECT * from course where course_id='$course_id'";
                                            $result6 = mysqli_query($conn, $sql6);
                                            $row6=mysqli_fetch_assoc($result6);

                                            $course_img = $row6['course_img'];
                                            $level = $row6['level'];
                                            $language = $row6['language'];
                                            $course_name = $row6['course_name'];
                                            $course_description = $row6['course_description'];
                                            $teacher_id = $row6['teacher_id'];
                                            $university = $row6['university'];
                                            if($university==1){
                                    ?>
                                    <a href="course-profile.php?course_id=<?php echo $course_id?>"
                                        style="text-decoration: none;color:#222">
                                        <div class="col-md-3">
                                            <div class="card" style="width: 18rem;height:28rem;">
                                                <img src="../images/courses/<?php echo $course_img?>"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <div class="file-info" style="margin: 0px 10px 15px 0;">
                                                        <span class="badge badge-dark text-light mr-2"
                                                            style="padding:5px;"><?php echo $level?></span>
                                                        <span class="badge badge-dark text-light mr-2"
                                                            style="padding:5px;"><?php echo $language?></span>
                                                    </div>
                                                    <h5 class="card-title"><?php echo $course_name?></h5>
                                                    <p class="card-text">
                                                        <?php echo substr($course_description, 0, 100)?>
                                                    </p>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <?php
                                                        $sql2 = "SELECT * from teachers where teacher_id='$teacher_id'";
                                                        $result2 = mysqli_query($conn, $sql2);
                                                        $row2=mysqli_fetch_assoc($result2);
                                                        $teacher_name = $row2['firstname']." ".$row2['lastname'];
                                                        $teacher_img = $row2['teacher_img'];
            
                                                        ?>
                                                            <span><img
                                                                    src="../images/teachers/<?php echo $teacher_img?>"
                                                                    class="img-fluid rounded-circle" alt=""
                                                                    width="30px">&nbsp;&nbsp;&nbsp;
                                                                <span
                                                                    class="text-dark"><?php echo $teacher_name?></span></span>
                                                            <?php
                                                                $sql9 = "SELECT * FROM course_rate WHERE course_id = '$course_id'";
                                                                $result9 = mysqli_query($conn, $sql9);
                                                                $count = $result9->num_rows;
                                                        
                                                                $query10 = "SELECT AVG(rating) AS average FROM course_rate WHERE course_id = '$course_id'";
                                                                $result10 = mysqli_query($conn, $query10);
                                                                $row10 = mysqli_fetch_assoc($result10);
                                                                $avg = $row10['average'];
                                                            ?>
                                                            <h6 class="m-2"><i class="fa fa-star mr-2"
                                                                    style="color:orange;"></i><?php echo round($avg,1)?>
                                                                <small
                                                                    style="font-size:10px;">(<?php echo $count?>)</small>
                                                            </h6>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                            }

                                            }
                                        }
                                    ?>

                                </div> <!-- .row -->
                            </div> <!-- .file-panel -->

                        </div> <!-- .file-container -->
                    </div> <!-- .col -->
                </div> <!-- .row -->

                <!-- new repo modal -->
                <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
                    aria-hidden="true" style="padding-top: 100px;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="varyModalLabel">New Repository</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="../create-repo.php" method="POST">
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <label for="eventTitle" class="col-form-label">Repo Name <span
                                                style="color:red;">*</span></label>
                                        <input type="text" class="form-control" id="eventTitle" name="name"
                                            placeholder="Add Repo Name" required>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-8">
                                            <label for="eventType">Pogramming Language <span
                                                    style="color:red;">*</span></label>
                                            <select id="eventType" class="form-control select2" name="lang" required>
                                                <option value="c">Select Language</option>
                                                <option value="c">C</option>
                                                <option value="cpp">C++</option>
                                                <option value="python">Python</option>
                                                <option value="php">PHP</option>
                                                <option value="node.js">NodeJS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="submit" name="submit" class="btn mb-2 btn-primary">Create
                                        Repo</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div> <!-- new event modal -->


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
    <script>
        $(document).ready(function () {

            $('.deletebtn').on('click', function () {

                $('#deleteModal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_id').val(data[0]);

            });
        });
    </script>
</body>

</html>