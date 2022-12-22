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

$university_id = $_SESSION['university_id'];

if(isset($_POST['add_course'])){

    $course_description = $_POST['course_description'];
    $course_name = $_POST['course_name'];
    $level = $_POST['level'];
    $language = $_POST['language'];
    $teacher_id = $_POST['teacher_id'];
    $random = substr(md5(mt_rand()), 0, 6);
    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "../images/courses/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    $query = "SELECT * FROM course WHERE course_name = '$course_name' AND teacher_id = '$teacher_id' AND level='$level'";
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

                $query2 = "INSERT INTO course(course_img, course_name, `level`,`language`, `course_description`, teacher_id,university,joincode)
                VALUES ('$name', '$course_name', '$level','$language', '$course_description', '$teacher_id', '$university_id', '$random')";
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


if(isset($_POST['delete_course'])){

    $course_id = $_POST['delete_id'];

    $query = "DELETE FROM course WHERE course_id='$course_id'";
    $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            $cls="success";
            $error = "Course Successfully Deleted.";
        } else {
            $cls="danger";
            $error = mysqli_error($conn);
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
    <title>CodeEve | Manage Courses</title>
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
                                <h2 class="page-title">Manage courses</h2>

                            </div>
                        </div>

                        <div class="user-container border-top">
                            <div class="user-panel mt-4">
                                <div class="row">
                                    <!-- Striped rows -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <strong class="card-title" style="font-size:18px;">Course Details</strong>
                                                <a class="float-right small btn btn-primary" style="padding:5px 10px;"
                                                    href="#!" data-toggle="modal" data-target="#addModal">Add Course</a>

                                            </div>
                                            <div class="card-body my-n2">
                                            <div class="alert alert-<?php echo $cls;?>">
                                                <?php 
                                                            if (isset($_POST['add_course']) || isset($_POST['delete_course'])){
                                                                echo $error;
                                                            }
                                                        ?>
                                            </div>
                                                <table class="table table-striped table-hover table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Course Profile</th>
                                                            <th>Course Name</th>
                                                            <th>Level</th>
                                                            <th>Language</th>
                                                            <th>Course Description</th>
                                                            <th>Teacher Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $sql1 = "SELECT * FROM course where university=$university_id";
                                                            $result1 = mysqli_query($conn, $sql1);
                                                            if($result1){
                                                                while($row1=mysqli_fetch_assoc($result1)){

                                                                $course_id=$row1['course_id'];
                                                                $course_img=$row1['course_img'];
                                                                $course_name=$row1['course_name'];
                                                                $course_description=$row1['course_description'];
                                                                $level=$row1['level'];
                                                                $language=$row1['language'];
                                                                $teacher_id=$row1['teacher_id'];
                                                                

                                                                $sql2 = "SELECT * FROM teachers WHERE teacher_id=$teacher_id";
                                                                $result2 = mysqli_query($conn, $sql2);
                                                                $row2=mysqli_fetch_assoc($result2);

                                                                $firstname=$row2['firstname'];
                                                                $lastname=$row2['lastname'];


                                                        ?>
                                                        <tr>
                                                            <td><?php echo $course_id ?></td>
                                                            <td><img src="../images/courses/<?php echo $course_img ?>"
                                                                    style="width:100px;border-radius: 20%;"
                                                                    alt="prouser"></td>
                                                            <td><h5><a href="uni-course-profile.php?course_id=<?php echo $course_id?>"><?php echo $course_name ?></a></h5></td>

                                                
                                                            <td><?php echo $level ?></td>
                                                            <td><?php echo $language ?></td>
                                                            <td><?php echo $course_description ?></td>
                                                            <td><?php echo $firstname." ".$lastname ?></td>

                                                            <td>
                                                            <button class="btn btn-danger deletebtn" data-toggle="modal"
                                                                            data-target="#deleteModal"><i class="fa fa-trash"></i></button>

                                                                
                                                            </td>
                                                        </tr>

                                                        <!-- Delete modal -->
                                                        <div class="modal fade" id="deleteModal" tabindex="-1"
                                                            role="dialog" aria-labelledby="eventModalLabel"
                                                            aria-hidden="true" style="padding-top: 100px;">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="varyModalLabel">
                                                                            Delete Course</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="" method="POST">
                                                                        <div class="modal-body p-4">
                                                                            <div class="form-group">
                                                                                <input type="hidden" class="form-control"
                                                                                    id="delete_id" name="delete_id">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <h5>Are You Sure You Want To Delete this
                                                                                    course.</h5>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="modal-footer d-flex justify-content-end">
                                                                            <button type="submit" name="delete_course"
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
                                            </div>
                                        </div>
                                    </div> <!-- Striped rows -->
                                </div> <!-- .row-->
                            </div> <!-- .course-panel -->

                        </div> <!-- .course-container -->
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
                                                    <input type="file" name="file" id="file" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>level</label>
                                                    <select class="form-control" name="level" id="level"
                                                         required>
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
                                                    <select class="form-control" name="language" id="language"
                                                         required>
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
                                                    <input type="text" class="form-control" name="course_name" id="course_name"
                                                        placeholder="Course Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Course Teacher</label>
                                                    <select class="form-control" name="teacher_id" id="teacher_id"
                                                         required>
                                                        <option>-- Select Teacher --</option>
                                                        <?php
                                                            $sql2 = "SELECT * FROM teachers where university=$university_id";
                                                            $result2 = mysqli_query($conn, $sql2);
                                                            if($result2){
                                                                while($row2=mysqli_fetch_assoc($result2)){

                                                                $teacher_id=$row2['teacher_id'];
                                                                $firstname=$row2['firstname'];
                                                                $lastname=$row2['lastname'];
                                                            ?>

                                                        <option value="<?php echo $teacher_id?>"><?php echo $firstname." ".$lastname?></option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Course Description</label>
                                                    <textarea class="form-control" name="course_description" id="course_description"
                                                        placeholder="Course Description"></textarea>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="submit" name="add_course" class="btn mb-2 btn-primary">Add course</button>
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