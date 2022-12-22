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

$image = $row['university_img'];
$university_name=$row['university_name'];
$about_me=$row['about'];
$established=$row['established'];
$contact=$row['contact'];
$email=$row['email'];
$address=$row['address'];
$city=$row['city'];
$zip=$row['zip'];

if (isset($_POST['submit_img'])) {

    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "../images/universities/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){

        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){

            // Convert to base64 
            $image_base64 = base64_encode(file_get_contents('../images/universities/'.$name));
            $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

            // Update Record
            $query2 = "UPDATE university SET `university_img`='$name' WHERE username='$username'";
            $query_run2 = mysqli_query($conn, $query2);

            $query3 = "UPDATE `recent` SET `image`='$name' WHERE `name`='$username'";
            $query_run3 = mysqli_query($conn, $query3);

            if ($query_run2 && $query_run3) {
                echo "<script> alert('Profile Image Successfully Updated.');
                window.location.href='dashboard.php';</script>";
            } 
            else {
                $cls="danger";
                $error = "Cannot Update Profile Image";
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

if (isset($_POST['submit'])) {

    $university_name = $_POST['university_name'];
    $established=$_POST['established'];
    $contact=$_POST['contact'];
    $email=$_POST['email'];
    $about_me=$_POST['about_me'];
    $address=$_POST['address'];
    $city=$_POST['city'];
    $zip=$_POST['zip'];

    $error = "";
    $cls="";

        // Update Record
        $query2 = "UPDATE universitys SET university_name='$university_name',
        established='$established', email='$email', contact='$contact',about_me='$about_me',
        `address`='$address', city='$city', zip='$zip' WHERE username='$username'";
        $query_run2 = mysqli_query($conn, $query2);
        
        if ($query_run2) {
            $cls="success";
            $error = "Profile Successfully Updated.";
        } 
        else {
            $cls="danger";
            $error = "Cannot Update Profile";
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
    <title>CodeEve | Profile</title>
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
          <div class="col-12 col-lg-10 col-xl-8">
            <h2 class="h3 mb-4 page-title">My Profile</h2>
            <div class="my-4">
              <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " id="profile-tab" href="security.php">Security</a>
                </li>
              </ul>
              <form action="" method="POST" enctype='multipart/form-data'>
                <div class="row mt-5 align-items-center">
                  <div class="col-md-3 text-center mb-5">
                    <div class="avatar avatar-xl">
                      <img src="../images/universities/<?php echo $image?>" alt="..." class="avatar-img">
                      <input type="file" name="file" id="file" style="padding-left:5px;padding-top:30px;padding-bottom:20px;">

                      <button type="submit" name="submit_img" class="btn btn-primary">Save Change</button>

                    </div>
                  </div>
                  <div class="col">
                    <div class="row align-items-center" style="padding-left:30px;">
                      <div class="col-md-7">
                        <h3 class="mb-1"><?php echo $university_name?></h3>
                        <p class="small mb-3"><span class="badge badge-dark"><?php echo $city;?>, Bangladesh</span></p>
                      </div>
                    </div>
                    <div class="row mb-4" style="padding-left:30px;">
                      <div class="col-md-7">
                        <p class="text-muted"><?php echo $about_me;?></p>
                      </div>
                      <div class="col">
                        <p class="small mb-0 text-muted"><?php echo $address?></p>
                        <p class="small mb-0 text-muted"><?php echo $city?> - <?php echo $zip;?></p>
                        <p class="small mb-0 text-muted"><?php echo $contact?></p>
                      </div>
                    </div>
                  </div>

                </div>
              </form>
              <hr class="my-4">
              <form action="" method="POST" enctype='multipart/form-data'>
                <div class="row">
                  <div class=" col-md-12">
                    <div class="alert alert-<?php echo $cls;?>">
                      <?php 
                        if (isset($_POST['submit']) || isset($_POST['submit_img'])){
                        echo $error;
                      }?>
                    </div>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="university_name">University Name</label>
                    <input type="text" name="university_name" class="form-control" placeholder="Enter University Name"
                      value="<?php echo $university_name?>" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="lastname">Established</label>
                    <input type="date" name="established" class="form-control" placeholder=""
                      value="<?php echo $established?>" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="lastname">About</label><br>
                    <textarea name="about_me" cols="105.5" rows="3" class="form-control"
                      placeholder="Write something about yourself..."><?php echo $about_me?></textarea>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email"
                      value="<?php echo $email?>" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="contact">Contact</label>
                    <input type="text" name="contact" class="form-control" placeholder="Enter Contact Number"
                      value="<?php echo $contact?>" required>
                  </div>
                </div>


                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" name="address" placeholder="Enter Address"
                    value="<?php echo $address?>" required>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="city">City</label>
                    <input type="text" class="form-control" name="city" placeholder="Enter City"
                      value="<?php echo $city?>" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="zip">Zip</label>
                    <input type="text" class="form-control" name="zip" placeholder="Enter Zip" value="<?php echo $zip?>"
                      required>
                  </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Save Change</button>
              </form>
            </div> <!-- /.card-body -->
          </div> <!-- /.col-12 -->
        </div> <!-- .row -->
      </div> <!-- .container-fluid -->

      <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
        aria-hidden="true">
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
                      <div class="my-0 text-muted small">Just create new layout Index, form, table</div>
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
                      <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
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
                      <div class="my-0 text-muted small">New layout has been attached to the menu</div>
                      <small class="badge badge-pill badge-light text-muted">1h ago</small>
                    </div>
                  </div>
                </div> <!-- / .row -->
              </div> <!-- / .list-group -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
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
  <script src="../dashboard/js/apps.js"></script>

</body>

</html>