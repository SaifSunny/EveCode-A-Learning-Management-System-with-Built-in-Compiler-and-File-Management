<?php
include_once("../database/config.php");
session_start();

if (!isset($_SESSION['adminname'])) {
  header("Location: ../admin_login.php");
}

$username = $_SESSION['adminname'];
$image=$_SESSION['image'];

$sql = "SELECT * FROM admin WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$pass=$row['password'];

if (isset($_POST['submit'])) {

  $old_pass = md5($_POST['old_pass']);

  $new_pass = $_POST['new_pass'];
  $con_pass=$_POST['con_pass'];

  $error = "";
  $cls="";

  if($pass ==  $old_pass){
    if (strlen($new_pass) > 5){
      if ($new_pass == $con_pass){
        // Update Password
        $save_pass = md5($new_pass);
        $query2 = "UPDATE admin SET `password`='$save_pass' WHERE username='$username'";
        $query_run2 = mysqli_query($conn, $query2);
            
        if ($query_run2) {
          $cls="success";
          $error = "Password Successfully Updated.";
        } 
        else {
          $cls="danger";
          $error = "Cannot Update Password";
        }
      }else{
        $cls="danger";
        $error = "Passwords does not Match";
      }
    }else{
      $cls="danger";
      $error = "Passwords has to be minimum of 6 Charecters";
    }
  }else{
    $cls="danger";
    $error = "Invalid! Old Password";
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
    <?php include_once("../templates/admin_header.php");?>
    <!-- Navigation end -->

    <main role="main" class="main-content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 col-xl-8">
            <h2 class="h3 mb-4 page-title">Settings</h2>
            <div class="my-4">
              <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="home-tab" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" id="profile-tab" href="security.php">Security</a>
                </li>
              </ul>
              <form method="POST" action="">

                <strong class="mb-0">Passwords</strong>
                <p>You can change your passwords here.</p>
                <hr>
                <div class=" col-md-12">
                  <div class="alert alert-<?php echo $cls;?>" style="padding=0; margin:0;">
                    <?php 
                        if (isset($_POST['submit'])){
                        echo $error;
                      }?>
                  </div>
                </div>
                <div class="row mb-4" style="padding-top:20px;">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="old_pass">Old Password</label>
                      <input type="password" class="form-control" name="old_pass" value="">
                    </div>
                    <div class="form-group">
                      <label for="new_pass">New Password</label>
                      <input type="password" class="form-control" name="new_pass">
                    </div>
                    <div class="form-group">
                      <label for="inputPassword6">Confirm Password</label>
                      <input type="password" class="form-control" name="con_pass">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <p class="mb-2">Password requirements</p>
                    <p class="small text-muted mb-2"> To create a new password, you have to meet all of the following
                      requirements: </p>
                    <ul class="small text-muted pl-4 mb-0">
                      <li> Minimum 8 character </li>
                      <li>At least one special character</li>
                      <li>At least one number</li>
                      <li>Cant be the same as a previous password </li>
                    </ul>
                  </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Save Change</button>
              </form>

              <hr class="my-4">
              <strong class="mb-0">System</strong>
              <p>Please enable system alert you will get.</p>
              <div class="list-group mb-5 shadow">
                <div class="list-group-item">
                  <div class="row align-items-center">
                    <div class="col">
                      <strong class="mb-0">Notify me about new features and updates</strong>
                      <p class="text-muted mb-0">Get updates about new feature that we add in the future.</p>
                    </div> <!-- .col -->
                    <div class="col-auto">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="alert3" checked>
                        <span class="custom-control-label"></span>
                      </div>
                    </div> <!-- .col -->
                  </div> <!-- .row -->
                </div> <!-- .list-group-item -->
                <div class="list-group-item">
                  <div class="row align-items-center">
                    <div class="col">
                      <strong class="mb-0">Notify me by email for latest news</strong>
                      <p class="text-muted mb-0">Get Updated about discounts and other news fron us.</p>
                    </div> <!-- .col -->
                    <div class="col-auto">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="alert4" checked>
                        <span class="custom-control-label"></span>
                      </div>
                    </div> <!-- .col -->
                  </div> <!-- .row -->
                </div> <!-- .list-group-item -->
                <div class="list-group-item">
                  <div class="row align-items-center">
                    <div class="col">
                      <strong class="mb-0">Notify me about tips on using account</strong>
                      <p class="text-muted mb-0">Get tips and tricks about using EVECODE.</p>
                    </div> <!-- .col -->
                    <div class="col-auto">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="alert5">
                        <span class="custom-control-label"></span>
                      </div>
                    </div> <!-- .col -->
                  </div> <!-- .row -->
                </div> <!-- .list-group-item -->
              </div> <!-- .list-group -->
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