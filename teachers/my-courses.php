<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['teachername'])) {
    header("Location: ../teacher_login.php");
}

$username = $_SESSION['teachername'];
$image=$_SESSION['image'];

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

if(isset($_POST['add_course'])){

    $course_description = $_POST['course_description'];
    $course_name = $_POST['course_name'];
    $level = $_POST['level'];
    $language = $_POST['language'];
    $price = $_POST['price'];

    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "../images/courses/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    $query = "SELECT * FROM course WHERE course_name = '$course_name' AND teacher_id = '$teacher_id'AND `course_name`='$course_name' AND level='$level'";
    $query_run = mysqli_query($conn, $query);
    if(!$query_run->num_rows > 0){
        
        // Check extension
        if( in_array($imageFileType,$extensions_arr) )
        {

            // Upload file
            if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){

                // Convert to base64 
                $image_base64 = base64_encode(file_get_contents('../images/courses/'.$name));
                $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

                // Insert record

                $query2 = "INSERT INTO course(course_img, course_name, `level`,`language`, `course_description`, teacher_id, price)
                VALUES ('$name', '$course_name', '$level','$language', '$course_description', '$teacher_id', '$price')";
                $query_run2 = mysqli_query($conn, $query2);
    
                if ($query_run2) {
                    $cls="success";
                    $error = "Course Successfully Added.";
                } 
                else {
                    $cls="danger";
                    $error = mysqli_error($conn);
                }
            }
        }
    
    }else{
        $cls="danger";
        $error = "Course Already Exists";
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
    <title>CodeEve | My Courses</title>
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
        <?php include_once("../templates/teacher_header.php");?>
        <!-- Navigation end -->

        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row align-items-center my-3">
                            <div class="col">
                                <h2 class="page-title">My Courses</h2>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-lg btn-primary" data-toggle="modal"
                                    data-target="#addModal"><span class="fe fe-plus fe-16 mr-3"></span>Add
                                    Course</button>
                            </div>
                        </div>
                        <div class="alert alert-<?php echo $cls;?>">
                            <?php 
                                                            if (isset($_POST['add_course']) || isset($_POST['delete_course'])){
                                                                echo $error;
                                                            }
                                                        ?>
                        </div>

                        <div class="file-container border-top">
                            <div class="file-panel mt-4">
                                <div class="row my-4 pb-4">

                                    <?php

                                    $sql = "SELECT * from course where teacher_id=$teacher_id";
                                    $result = mysqli_query($conn, $sql);
                                    if($result){
                                        while($row=mysqli_fetch_assoc($result)){

                                            $course_id = $row['course_id'];

                                            $sql1 = "SELECT * from course where course_id='$course_id'";
                                            $result1 = mysqli_query($conn, $sql1);
                                            $row1=mysqli_fetch_assoc($result1);

                                            $course_img = $row['course_img'];
                                            $level = $row['level'];
                                            $language = $row['language'];
                                            $course_name = $row['course_name'];
                                            $course_description = $row['course_description'];

                                    ?>
                                    <div class="col-md-3">
                                        <a href="course-profile.php?course_id=<?php echo $course_id?>"
                                            style="text-decoration:none;color:#222;">
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

                                                            <span><img src="../images/teachers/<?php echo $image?>"
                                                                    class="img-fluid rounded-circle" alt=""
                                                                    width="30px">&nbsp;&nbsp;&nbsp;
                                                                <span
                                                                    class="text-dark"><?php echo $firstname." ".$lastname?></span></span>
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
                                                                    style="font-size:10px;">(<?php echo round($count,1)?>)</small>
                                                            </h6>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </a>
                                    </div>
                                    <?php

                                            }
                                        }
                                    ?>




                                </div> <!-- .row -->
                            </div> <!-- .file-panel -->

                        </div> <!-- .file-container -->
                    </div> <!-- .col -->
                </div> <!-- .row -->




                <!-- add modal -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="varyModalLabel">Add Course</h5>
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
                                                    <label>Course Profile</label>
                                                    <input type="file" name="file" id="file" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>level</label>
                                                    <select class="form-control" name="level" id="level" required>
                                                        <option>-- Select Level --</option>
                                                        <option value="Beginner">Beginner</option>
                                                        <option value="Intermediate">Intermediate</option>
                                                        <option value="Expert">Expert</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Language</label>
                                                    <select class="form-control" name="language" id="language" required>
                                                        <option>-- Select Language --</option>
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
                                                    <label>Course Name</label>
                                                    <input type="text" class="form-control" name="course_name"
                                                        id="course_name" placeholder="Course Name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Enrollment Fee</label>
                                                    <input type="text" class="form-control" name="price" id="price"
                                                        placeholder="Enrollment Fee" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Course Description</label>
                                                    <textarea class="form-control" name="course_description"
                                                        id="course_description" placeholder="Course Description"
                                                        required></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="submit" name="add_course" class="btn mb-2 btn-primary">Add
                                        course</button>
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

</body>

</html>