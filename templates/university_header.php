<?php
include_once("../database/config.php");

$username = $_SESSION['uniname'];
$image=$_SESSION['image'];

$sql = "SELECT * FROM university WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$img=$row['university_img'];

$_SESSION['image'] = $img;
$_SESSION['university_id'] = $row['university_id'];
$_SESSION['username'] = $row['username'];

$university_id = $_SESSION['university_id'];
?>

<nav class="topnav navbar navbar-light">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    <ul class="nav">
        <li class="nav-item nav-notif">
            <a class="nav-link text-muted my-2" href="#" data-toggle="modal" data-target=".modal-notif">
                <span class="fe fe-bell fe-16"></span>
                <span class="dot dot-md bg-success"></span>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2"> @<?php echo $username?>
                    <img src="../images/universities/<?php echo $image?>" alt="..." style="height:40px; width:60px; border-radius:20%">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="./profile.php">Profile</a>
                <a class="dropdown-item" href="./security.php">Security</a>
                <a class="dropdown-item" href="./logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>

<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./dashboard.php">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120"
                    xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
                </svg>
            </a>
        </div>

        <ul class="navbar-nav flex-fill w-100 mb-2" style="margin-top:20px;">
            <li class="nav-item w-100">
                <a class="nav-link" href="dashboard.php">
                    <i class="fa fa-calendar fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item w-100">
                <a class="nav-link" href="./teachers.php">
                    <i class="fa fa-user-graduate fe-16"></i>
                    <span class="ml-3 item-text">Manage Teachers</span>
                </a>
            </li>
            
            <li class="nav-item w-100">
                <a class="nav-link" href="./courses.php">
                <i class="fa fa-book"></i>
                    <span class="ml-3 item-text">Manage Courses</span>
                </a>
            </li>
        </ul>



    </nav>
</aside>