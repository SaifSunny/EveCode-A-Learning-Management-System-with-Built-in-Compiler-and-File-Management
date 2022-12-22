<?php

include './database/config.php';
error_reporting(0);


$dir_path = getcwd();


session_start();

if (isset($_SESSION['teachername'])) {
    header("Location: teachers/teacher_home.php");
}

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);
	$p = $_POST['password'];
    $error = "";
    $cls="danger";

    if ($password == $cpassword) {
            if (strlen($p) > 5) {

                $query = "SELECT * FROM teachers WHERE username = '$username'";
                $query_run = mysqli_query($conn, $query);

                if (!$query_run->num_rows > 0) {
                    $query = "SELECT * FROM teachers WHERE username = '$username' AND email = '$email'";
                    $query_run = mysqli_query($conn, $query);

                    if(!$query_run->num_rows > 0){
                        $query2 = "INSERT INTO teachers(username,email,`password`)
                        VALUES ('$username', '$email', '$password')";
                        $query_run2 = mysqli_query($conn, $query2);



                        if ($query_run2) {
                            $_SESSION['teachername'] = $_POST['username'];
                            mkdir($dir_path."/ide"."/".$username, 0777);

                            echo "<script> alert('Regestration Successfull.');
                            window.location.href='teachers/profile.php';
                            </script>";
                        } 
                        else {
                            $error = "Cannot Register";
                        }
                    }
                    else{
                        $error = "Teacher Already Exists";
                    }

                } 
                else {
                    $error = "Username Already Exists";
                }
            } 
            else {
                $error =  "Password has to be minimum of 6 charecters";
            }
    } 
    else {
        $error = 'Passwords did not Matched.';
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
    <title>EveCode | Teacher SignUp</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="dashboard/css/simplebar.css">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="dashboard/css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="dashboard/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="dashboard/css/app-light.css" id="lightTheme">

</head>

<body class="light" style="margin: 0; height: 100%; overflow: hidden;">
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-6 col-md-8 col-10 mx-auto" action="" method="POST">
                <div class="mx-auto">
                    <h1 style="padding-top:25px;">Sign Up</h1>
                </div>
                <div class="alert alert-<?php echo $cls;?>" style="font-size:15px;">
                    <?php 
                        if (isset($_POST['submit'])){
                            echo $error;
                        }
                    ?>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstname">First Name <span style="color:red;">*</span></label>
                        <input type="text" id="firstname" name="firstname" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">Last Name <span style="color:red;">*</span></label>
                        <input type="text" id="lastname" name="lastname" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstname">Email <span style="color:red;">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">User Name <span style="color:red;">*</span></label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPassword5">New Password <span style="color:red;">*</span></label>
                            <input type="password" name="password" class="form-control" id="inputPassword5">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword6">Confirm Password <span style="color:red;">*</span></label>
                            <input type="password" name="cpassword" class="form-control" id="inputPassword6">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">Password requirements</p>
                        <p class="small text-muted mb-2"> To create a new password, you have to meet all of the
                            following requirements: </p>
                        <ul class="small text-muted pl-4 mb-0">
                            <li> Minimum 6 character </li>
                            <li>At least one special character</li>
                            <li>At least one number</li>
                        </ul>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign up</button>

                <div class="text-center mt-4 font-weight-light">
                    Already have an account? <a href="teacher_login.php" class="text-primary">Sign In Now.</a>
                </div>
                <p class="mt-5 mb-3 text-muted text-center">Copyright © 2022 EveCode</p>
            </form>
        </div>
    </div>
    <script src="dashoard/js/jquery.min.js"></script>
    <script src="dashoard/js/popper.min.js"></script>
    <script src="dashoard/js/moment.min.js"></script>
    <script src="dashoard/js/bootstrap.min.js"></script>
    <script src="dashoard/js/simplebar.min.js"></script>
    <script src='dashoard/js/daterangepicker.js'></script>
    <script src='dashoard/js/jquery.stickOnScroll.js'></script>
    <script src="dashoard/js/tinycolor-min.js"></script>
    <script src="dashoard/js/config.js"></script>
    <script src="dashoard/js/apps.js"></script>

</body>

</html>
</body>

</html>