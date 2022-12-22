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

$image = $row['teacher_img'];
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
    <title>EveCode | Teacher Repos</title>
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
</head>

<body class="vertical  light  ">
    <div class="wrapper">
        <!-- Navigation Start -->
        <?php include_once("../templates/teacher_header.php");?>
        <!-- Navigation end -->

        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row mt-5 align-items-center">
                    <div class="col-md-3 text-center mb-5">
                        <div class="avatar avatar-xl">
                            <img src="../images/teachers/<?php echo $image?>" alt="..."
                                class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row align-items-center" style="padding-left:30px;">
                            <div class="col-md-7">
                                <h3 class="mb-1"><?php echo $firstname." ".$lastname?></h3>
                                <p class="small mb-3"><span class="badge badge-dark"><?php echo $city;?>,
                                        Bangladesh</span></p>
                            </div>
                        </div>
                        <div class="row mb-4" style="padding-left:30px;">
                            <div class="col-md-7">
                                <p class=""><?php echo $about_me;?></p>
                                <p class="small mb-0">Number of Files: <?php echo count(glob("C:/xampp/htdocs/EveCode/ide/$username/*"));;?></p>
                                <?php
                                    function folderSize($dir){
                                        $count_size = 0;
                                        $count = 0;
                                        $dir_array = scandir($dir);
                                        foreach($dir_array as $key=>$filename){
                                            if($filename!=".." && $filename!="."){
                                            if(is_dir($dir."/".$filename)){
                                                $new_foldersize = foldersize($dir."/".$filename);
                                                $count_size = $count_size+ $new_foldersize;
                                                }else if(is_file($dir."/".$filename)){
                                                $count_size = $count_size + filesize($dir."/".$filename);
                                                $count++;
                                                }
                                        }
                                        }
                                        return $count_size;
                                        }
                                ?>
                                <?php
                                $size=folderSize("C:/xampp/htdocs/EveCode/ide/$username");

                                if($size < 1024) {
                                ?>
                                <p class="small mb-0">Total File Size: <?php echo $size. " Bytes"?></p>
                                <?php
                                }else if($size < 1024000) {
                                ?>
                                <p class="small mb-0">Total File Size: <?php echo round($size,1)." KB"?></p>

                                <?php
                                }else {
                                ?>
                                <p class="small mb-0 ">Total File Size: <?php echo round($size,1). "MB"?></p>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col">
                                <p class="small mb-0 "><?php echo $address?></p>
                                <p class="small mb-0 "><?php echo $city?> - <?php echo $zip;?></p>
                                <p class="small mb-0 "><?php echo $contact?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 ">
                        <div class="row align-items-center my-4">
                            <div class="col">
                                <h2 class="page-title">My Repos</h2>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-lg btn-primary" data-toggle="modal"
                                    data-target="#eventModal"><span class="fe fe-plus fe-16 mr-2"></span>New
                                    Repo</button>
                            </div>
                        </div>

                        <table class="table table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Language</th>
                                    <th>File Size</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                        $sql = "SELECT * FROM teacher_files WHERE teacher_id = '$teacher_id' ORDER BY file_id DESC";
                                        $result = mysqli_query($conn, $sql);
                                        if($result){
                                            while($row=mysqli_fetch_assoc($result)){
                                            
                                                $file_id =$row['file_id'];
                                                $filename =$row['filename'];
                                                $filetype =$row['filetype'];
                                                $created =$row['created'];
                                                $description =$row['description'];
                                            

                                                $icon = "";
                                                $com_lang = "";
                                                
                                                if($filetype=="c"){
                                                    $icon = "c-lang.png";
                                                    $lang="C";
                                                }
                                                if($filetype=="cpp"){
                                                    $icon = "cpp.png";
                                                    $lang="C++";

                                                }
                                                if($filetype=="python"){
                                                    $icon = "python.png";
                                                    $lang="Python";

                                                }
                                                if($filetype=="php"){
                                                    $icon = "php.png";
                                                    $lang="PHP";

                                                }
                                                if($filetype=="node.js"){
                                                    $icon = "node.png";
                                                    $lang="Javascript";

                                                }

                                    ?>
                                <tr>
                                    <td class="text-center" style="display:none;">
                                        <div class="circle circle-sm bg-light">
                                            <?php echo $file_id?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="circle circle-sm bg-light">
                                            <img src="../images/icons/<?php echo $icon?>" width="100%" alt="">
                                        </div>
                                    </td>
                                    <th scope="row"><a
                                            href="../teacher-compiler.php?file_id=<?php echo $file_id?>"><strong><?php echo $filename?>.<?php echo $filetype?></strong></a><br />

                                        <span class="badge badge-light text-muted mr-2"><?php echo $created ?></span>

                                    </th>
                                    <td class="text-muted"><?php echo $lang ?></td>
                                    <?php

                                        $size= filesize("C:/xampp/htdocs/EveCode/ide/$username/$filename.$filetype");

                                        if($size < 1024) {
                                        ?>
                                    <td class="text-muted"><?php echo $size. " Bytes"?></td>
                                    <?php
                                        }else if($size < 1024000) {
                                        ?>
                                    <td class="text-muted"><?php echo round(($size / 1024 ), 1)." KB"?></td>
                                    <?php
                                        }else {
                                        ?>
                                    <td class="text-muted"><?php echo round(($size / 1024000), 1) . "MB"?></td>
                                    <?php
                                        }
                                    ?>
                                    <td>
                                        <div class="file-action">
                                            <button type="button"
                                                class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu m-2">

                                                <a class="dropdown-item" href="../teacher-compiler.php?file_id=<?php echo $file_id?>"><i
                                                        class="fe fe-edit-3 fe-12 mr-4"></i>Edit Repo</a>
                                                <a class="dropdown-item deletebtn" href="#" data-toggle="modal"
                                                    data-target="#deleteModal"><i
                                                        class="fe fe-delete fe-12 mr-4"></i>Delete</a>
                                                <a class="dropdown-item"
                                                    href="../download-teacher-repo.php?file_id=<?php echo $file_id?>"><i
                                                        class="fe fe-download fe-12 mr-4"></i>Download</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete modal -->
                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                    aria-labelledby="eventModalLabel" aria-hidden="true" style="padding-top: 100px;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="varyModalLabel">Delete Repository</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="../delete-teacher-repo.php" method="POST">
                                                <div class="modal-body p-4">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="delete_id"
                                                            name="file_id">
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
                    </div>
                </div> <!-- .row -->
            </div>

            <!-- .container-fluid -->
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
                        <form action="../create-teacher-repo.php" method="POST">
                            <div class="modal-body p-4">
                                <div class="form-group">
                                    <label for="eventTitle" class="col-form-label">Repo Name</label>
                                    <input type="text" class="form-control" id="eventTitle" name="name"
                                        placeholder="Add Repo Name">
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="eventType">Programming Language</label>
                                        <select id="eventType" class="form-control select2" name="lang">
                                            <option>Choose Language</option>
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
            </div> <!-- new repo modal -->


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