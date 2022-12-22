<?php
include_once("../database/config.php");

$teachername = $_SESSION['teachername'];
$image=$_SESSION['image'];

$sql = "SELECT * FROM teachers WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$img=$row['teacher_img'];

$_SESSION['image'] = $img;
$_SESSION['teacher_id'] = $row['teacher_id'];
$_SESSION['username'] = $row['username'];

$teacher_id = $_SESSION['teacher_id'];
$university = $row['university'];
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
                    <img src="../images/teachers/<?php echo $image?>" alt="..." class="avatar-img rounded-circle">
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

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>My Files</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="dashboard.php">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item w-100"> 
                <a class="nav-link" href="./my_repo.php">
                    <i class="fe fe-save fe-16"></i>
                    <span class="ml-3 item-text">My Repos</span>
                </a>
            </li>

        </ul>

        <?php
        if($university==1){
        ?>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Teach</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="./my-courses.php">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">My Courses</span>
                </a>
            </li>
        </ul>
        <?php
        }else{
        ?>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Academic</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="./uni-courses.php">
                    <i class="fe fe-book fe-16"></i>
                    <span class="ml-3 item-text">My Courses</span>
                </a>
            </li>
        </ul>
        <?php
        }
        ?>
    </nav>
</aside>