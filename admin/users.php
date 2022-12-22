<?php
include_once("../database/config.php");

session_start();
$username = $_SESSION['adminname'];

if (!isset($_SESSION['adminname'])) {
    header("Location: ../admin_login.php");
}

$sql = "SELECT * FROM admin WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$img=$row['admin_img'];

$_SESSION['image'] = $img;
$_SESSION['admin_id'] = $row['admin_id'];
$_SESSION['username'] = $row['username'];

$admin_id = $_SESSION['admin_id'];

if(isset($_POST['add_user'])){

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $username = $_POST['username'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];


    $p = $_POST['password'];
    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "../images/users/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    if (strlen($p) > 5) {
    
        $query = "SELECT * FROM users WHERE username = '$username'";
        $query_run = mysqli_query($conn, $query);
        if (!$query_run->num_rows > 0) {

            $query = "SELECT * FROM users WHERE username = '$username' AND email = '$email'";
            $query_run = mysqli_query($conn, $query);
            if(!$query_run->num_rows > 0){

                // Check extension
                if( in_array($imageFileType,$extensions_arr) ){

                    // Upload file
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){

                        // Convert to base64 
                        $image_base64 = base64_encode(file_get_contents('../images/users/'.$name));
                        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

                        // Insert record

                        $query2 = "INSERT INTO users(username,email,`password`,firstname,lastname,contact,gender,birthday,user_img, `address`, city, zip)
                        VALUES ('$username', '$email', '$password', '$firstname', '$lastname', '$contact', '$gender', '$birthday', '$name', '$address', '$city', '$zip')";
                        $query_run2 = mysqli_query($conn, $query2);
                        mkdir("C:/xampp/htdocs/EveCode/ide/".$username, 0777);
            
                        if ($query_run2) {
                            $cls="success";
                            $error = "User Successfully Added.";
                        } 
                        else {
                            $cls="danger";
                            $error = mysqli_error($conn);
                        }

                    }else{
                        $cls="danger";
                        $error = 'Unknown Error Occurred.';
                    }
                }else{
                    $cls="danger";
                    $error = 'Invalid File Type';
                }
            }
            else{
                $cls="danger";
                $error = "User Already Exists";
            }
            
        }else{
            $cls="danger";
            $error = "Username Already Exists";
        }
    }else{
        $cls="danger";
        $error = 'Password has to be minimum of 6 charecters.';
    }
   
}


if(isset($_POST['delete_user'])){

    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM users WHERE user_id='$user_id'";
    $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            $cls="success";
            $error = "User Successfully Deleted.";
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
    <title>CodeEve | Manage Users</title>
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
        <?php include_once("../templates/admin_header.php");?>
        <!-- Navigation end -->
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row align-items-center my-3">
                            <div class="col">
                                <h2 class="page-title">Manage Users</h2>

                            </div>
                        </div>

                        <div class="user-container border-top">
                            <div class="user-panel mt-4">
                                <div class="row">
                                    <!-- Striped rows -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <strong class="card-title" style="font-size:18px;">User Details</strong>
                                                <?php
                                                    $sql = "SELECT * from users";
                                                    $result = mysqli_query($conn, $sql);
                                                    $count = $result->num_rows;
                                                ?>
                                                <div class="float-right">
                                                    Total users: <?php echo $count?>
                                                    <a class="small btn btn-primary" style="padding:5px 10px;margin-left:20px;"
                                                    href="#!" data-toggle="modal" data-target="#addModal">Add User</a>
                                                </div>


                                            </div>
                                            <div class="card-body my-n2">
                                            <div class="alert alert-<?php echo $cls;?>">
                                                <?php 
                                                            if (isset($_POST['add_user']) || isset($_POST['delete_user'])){
                                                                echo $error;
                                                            }
                                                        ?>
                                            </div>
                                                <table class="table table-striped table-hover table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Profile</th>
                                                            <th>Name</th>
                                                            <th>Gender</th>
                                                            <th>Birthday</th>
                                                            <th>Contact</th>
                                                            <th>Email</th>
                                                            <th>Address</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $sql1 = "SELECT * FROM users";
                                                            $result1 = mysqli_query($conn, $sql1);
                                                            if($result1){
                                                                while($row1=mysqli_fetch_assoc($result1)){

                                                                $firstname=$row1['firstname'];
                                                                $lastname=$row1['lastname'];
                                                                $birthday=$row1['birthday'];
                                                                $gender=$row1['gender'];
                                                                $contact=$row1['contact'];
                                                                $email=$row1['email'];
                                                                $address=$row1['address'];
                                                                $city=$row1['city'];
                                                                $zip=$row1['zip'];
                                                                $image=$row1['user_img'];
                                                                $user_id=$row1['user_id'];

                                                        ?>
                                                        <tr>
                                                            <td><?php echo $user_id ?></td>
                                                            <td><img src="../images/users/<?php echo $image ?>"
                                                                    style="width:50px;border-radius: 20%;"
                                                                    alt="prouser"></td>
                                                            <td><?php echo $firstname." ".$lastname ?></td>
                                                            <td><?php echo $gender ?></td>
                                                            <td><?php echo $birthday ?></td>
                                                            <td><?php echo $contact ?></td>
                                                            <td><?php echo $email ?></td>
                                                            <td><?php echo $address." ".$city."-".$zip ?></td>

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
                                                                            Delete User</h5>
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
                                                                                    User.</h5>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="modal-footer d-flex justify-content-end">
                                                                            <button type="submit" name="delete_user"
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