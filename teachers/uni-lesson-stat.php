<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../teacher_login.php");
}

$username = $_SESSION['teachername'];
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

$sql = "SELECT * FROM teachers WHERE username='$username'";
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

?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>CodeEve | Lesson Completion Report</title>
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
        <?php include_once("../templates/teacher_header.php");?>
        <!-- Navigation end -->
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row align-items-center my-3">
                            <div class="col">
                                <h2 class="page-title">Lesson Completion Report</h2>

                            </div>
                        </div>

                        <div class="user-container border-top">
                            <div class="user-panel mt-4">
                                <div class="row">
                                    <!-- Striped rows -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <strong class="card-title" style="font-size:18px;">Student
                                                    Progress</strong>


                                            </div>
                                            <div class="card-body my-n2">

                                                <table class="table table-striped table-hover table-borderless"
                                                    style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                            <th style="color:#222;">Image</th>
                                                            <th style="color:#222;">Name</th>
                                                            <?php 
                                                                $sql1 = "SELECT * FROM course_lessons where course_id=$course_id";
                                                                $result1 = mysqli_query($conn, $sql1);
                                                                if($result1){
                                                                    while($row1=mysqli_fetch_assoc($result1)){

                                                                    $lesson_no=$row1['lesson_no'];
                                                                    $lesson_id=$row1['lesson_id'];

                                                            ?>
                                                            <th style="color:#222;">Lesson <?php echo $lesson_no?></th>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                            <th style="color:#222;">Total Marks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $sql2 = "SELECT * FROM course_students where course_id=$course_id";
                                                            $result2 = mysqli_query($conn, $sql2);
                                                            if($result2){
                                                                while($row2=mysqli_fetch_assoc($result2)){

                                                                $user_id=$row2['user_id'];

                                                                $sql3 = "SELECT * FROM users WHERE user_id='$user_id'";
                                                                $result3 = mysqli_query($conn, $sql3);
                                                                $row3=mysqli_fetch_assoc($result3);

                                                                $firstname=$row3['firstname'];
                                                                $lastname=$row3['lastname'];
                                                                $user_img=$row3['user_img'];
                                                                        
                                                            ?>
                                                        <tr>
                                                            <td><img src="../images/users/<?php echo $user_img ?>"
                                                                    style="width:50px;border-radius: 20%;"
                                                                    alt="prouser"></td>
                                                            <td><?php echo $firstname." ".$lastname?></td>

                                                            <?php 
                                                            $total=0;
                                                            $count=0;
                                                                    $sql5 = "SELECT * FROM course_lessons where course_id=$course_id";
                                                                    $result5 = mysqli_query($conn, $sql5);
                                                                    if($result5){
                                                                        while($row5=mysqli_fetch_assoc($result5)){

                                                                        $lesson_id=$row5['lesson_id'];

                                                                        $sql4= "SELECT * FROM course_lesson_complete where lesson_id=$lesson_id AND user_id='$user_id'";
                                                                        $result4 = mysqli_query($conn, $sql4);
                                                                        
                                                                            if ($result4->num_rows > 0) {
                                                                            
                                                            ?>
                                                            <td><?php echo $mark =100; $total+=$mark; $count++;?></td>
                                                                <?php
                                                                    }else{
                                                                ?>
                                                            <td><?php echo $mark =0; $total+=$mark; $count++;?></td>
                                                                <?php
                                                                        }
                                                                    }
                                                                ?>
                                                                <td><?php echo $total/$count;?></td>
                                                        </tr>
                                                        <?php        
                                                                    }
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




                <!-- add modal -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="varyModalLabel">Add User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" method="POST" enctype='multipart/form-data'>
                                <div class="modal-body p-4">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Profile</label>
                                                    <input type="file" name="file" id="file" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" class="form-control" name="firstname"
                                                        id="firstname" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" class="form-control" name="lastname"
                                                        id="lastname" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Birthday</label>
                                                    <input type="date" class="form-control" name="birthday"
                                                        id="birthday" placeholder="Birthday">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select class="form-control" name="gender" id="gender"
                                                        placeholder="Gender" required>
                                                        <option>-- Select Gender --</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" name="email" id="email"
                                                        placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Contact</label>
                                                    <input type="text" class="form-control" name="contact" id="contact"
                                                        placeholder="Contact">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" name="username"
                                                        id="username" placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="text" class="form-control" name="password"
                                                        id="password" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control" name="address" id="address"
                                                        placeholder="Address">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" class="form-control" name="city" id="city"
                                                        placeholder="City">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Zip</label>
                                                    <input type="text" class="form-control" name="zip" id="zip"
                                                        placeholder="Zip">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="submit" name="add_user" class="btn mb-2 btn-primary">Add User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- add modal -->



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


    </script>
</body>

</html>