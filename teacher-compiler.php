<?php
include_once("./database/config.php");
session_start();

$username = $_SESSION['username'];
$teacher_id = $_SESSION['teacher_id'];
$image=$_SESSION['image'];

$file_id=$_GET['file_id'];

$sql = "SELECT * FROM teacher_files WHERE `file_id`='$file_id'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
        
$filename = $row['filename'];
$filetype = $row['filetype'];
$description = $row['description'];

$dir_path = getcwd();
$file_path = $dir_path."/ide"."/".$username."/".$filename.".".$filetype;

$icon = "";
$com_lang = "";

if($filetype=="c"){
    $icon = "images/icons/c-lang.png";
    $com_lang = "c";
    $mode = "c_cpp";
}
if($filetype=="cpp"){
    $icon = "images/icons/cpp.png";
    $com_lang = "cpp";
    $mode = "c_cpp";

}
if($filetype=="python"){
    $icon = "images/icons/python.png";
    $com_lang = "python";
    $mode = "python";

}
if($filetype=="php"){
    $icon = "images/icons/php.png";
    $com_lang = "php";
    $mode = "php";

}
if($filetype=="node.js"){
    $icon = "images/icons/node.png";
    $com_lang = "node.js";
    $mode = "javascript";
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
    <title>Evecode | Code Editor</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="../dashboard/css/simplebar.css">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./dashboard/css/feather.css">
    <link rel="stylesheet" href="./dashboard/css/select2.css">
    <link rel="stylesheet" href="./dashboard/css/dropzone.css">
    <link rel="stylesheet" href="./dashboard/css/uppy.min.css">
    <link rel="stylesheet" href="./dashboard/css/jquery.steps.css">
    <link rel="stylesheet" href="./dashboard/css/jquery.timepicker.css">
    <link rel="stylesheet" href="./dashboard/css/quill.snow.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="./dashboard/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="./dashboard/css/app-light.css" id="lightTheme">
    <style>
        .codearea {
            display: flex;
            flex-direction: column;
        }

        .code-box {
            background: #212121;
            color: #00ff00;
            font-family: monospace;
            padding: 20px;
        }
    </style>
</head>

<body class="horizontal light">
    <div class="wrapper">
        <!-- Navigation Start -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white flex-row border-bottom shadow"
            style="padding-left:50px;padding-right:50px;">
            <div class="container-fluid">
                <div class="d-flex">
                    <div>
                        <a class="navbar-brand mx-lg-1 mr-0" href="teachers/dashboard.php">
                            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                y="0px" viewBox="0 0 120 120" xml:space="preserve">
                                <g>
                                    <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                                    <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                                    <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                                </g>
                            </svg>
                        </a>
                    </div>

                    <div class="d-flex">
                        <a class="nav-link dropdown-toggle pr-0" href="#" id="navbarDropdownMenuLink"
                            style="color:#222; font-weight:600;" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="avatar avatar-sm mt-2"><?php echo $filename." .".$filetype?></span>
                            <img src="<?php echo $icon ?>" alt="Python" width="28px;" height="28px;"
                                style="margin-left:7px;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink"
                            style="padding:20px; width: 400px !important; height: 360px !important; margin-left:100px;">

                            <form action="update-teacher-compiler-repo.php" method="POST">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="file_id" name="file_id" value="<?php echo $file_id?>"
                                    required>
                                </div>
                                <div class="form-group">
                                    <label for="filename" class="col-form-label">Repo Name</label>
                                    <input type="text" class="form-control" id="filename" name="filename"
                                        placeholder="Repo Name" value="<?php echo $filename?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-form-label">Description</label>
                                    <textarea name="description" cols="105.5" rows="5" class="form-control"
                                        placeholder="Write something about this Repo..."><?php echo $description?></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn mb-2 btn-primary">Update
                                        Repo</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div style="margin-left:10%;">
                    <button class="btn btn-primary" onclick="executeCode();"><i
                            class="fa-solid fa-play"></i>&nbsp;&nbsp;
                        Run</button> &nbsp;
                </div>
                <div class="d-flex">
                    <div class="d-flex">
                        <div class="control-panel" style="padding-top:4%; padding-right: 20px;">
                            Theme:
                            <select id="themename" class="themename " onchange="changetheme()" style="color:#222;">
                                <option value="monokai"> Monokai </option>
                                <option value="nord_dark"> Nord_dark </option>
                                <option value="eclipse"> Eclipse </option>
                                <option value="solarized_dark"> Solarized_dark </option>
                                <option value="solarized_light"> Solarized_light </option>
                                <option value="kr_theme"> Kr_theme </option>
                            </select>
                            &nbsp;
                            FontSize:
                            <select id="fontsize" class="fontsize " onchange="changeFontSize()">
                                <option value="normal"> Normal </option>
                                <option value="15"> 15 </option>
                                <option value="20"> 20 </option>
                                <option value="25"> 25 </option>
                                <option value="30"> 30 </option>
                                <option value="35"> 35 </option>
                            </select>

                            <select id="languages" class="languages" hidden>
                                <option value="$com_lang"> <?php echo $com_lang?> &nbsp;&nbsp;&nbsp;</option>
                            </select>
                            &nbsp;
                        </div>
                    </div>

                    <div>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown ml-lg-0">
                                <a class="nav-link dropdown-toggle text-muted" href="#" id="navbarDropdownMenuLink"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="avatar avatar-sm mt-2">@<?php echo $username?>
                                        <img src="./images/teachers/<?php echo $image?>" alt="..."
                                            class="avatar-img rounded-circle">
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <li class="nav-item">
                                        <a class="nav-link pl-3" href="teachers/profile.php">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pl-3" href="teachers/security.php">Security</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pl-3" href="teachers/logout.php">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>
        <!-- Navigation end -->

        <main role="main" class="main-content" style="padding:0; margin:0;">

            <div class="container-fluid">
                <div class="row justify-content-center" style="">
                    <div class="editor col-8" id="editor" style="height: 91vh;overflow:auto;"><?php echo file_get_contents($file_path);?></div>
                    <div class="output col-4" style="font-family: Courier New, Courier, monospace; color:white; background:#222;padding:20px;"></div>
                </div>
            </div>


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
                                    </div>
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
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear
                                All</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script src="./dashboard/js/jquery.min.js"></script>
    <script src="./dashboard/js/popper.min.js"></script>
    <script src="./dashboard/js/moment.min.js"></script>
    <script src="./dashboard/js/bootstrap.min.js"></script>
    <script src="./dashboard/js/simplebar.min.js"></script>
    <script src='./dashboard/js/daterangepicker.js'></script>
    <script src='./dashboard/js/jquery.stickOnScroll.js'></script>
    <script src="./dashboard/js/tinycolor-min.js"></script>


    <script src="./dashboard/js/gauge.min.js"></script>
    <script src="./dashboard/js/jquery.sparkline.min.js"></script>
    <script src="./dashboard/js/apexcharts.min.js"></script>
    <script src="./dashboard/js/apexcharts.custom.js"></script>
    <script src='./dashboard/js/jquery.mask.min.js'></script>
    <script src='./dashboard/js/select2.min.js'></script>
    <script src='./dashboard/js/jquery.steps.min.js'></script>
    <script src='./dashboard/js/jquery.validate.min.js'></script>
    <script src='./dashboard/js/jquery.timepicker.js'></script>
    <script src='./dashboard/js/uppy.min.js'></script>
    <script src='./dashboard/js/quill.min.js'></script>


    <script src="home/js/lib/ace.js"></script>
    <script src="home/js/lib/theme-monokai.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        let editor;

        window.onload = function () {
            editor = ace.edit("editor");
            editor.setTheme("ace/theme/monokai");
            editor.session.setMode("ace/mode/<?php echo $mode?>");
        }

        function changetheme() {
            var themename = $("#themename").val();
            editor = ace.edit("editor");
            editor.setTheme("ace/theme/" + themename);
        }

        function changeFontSize() {
            $('.editor').each(function (index) {
                var size = $("#fontsize").val();
                editor = ace.edit(this);
                if (size == 15) {
                    editor.setFontSize(15);
                } else if (size == 'normal') {
                    editor.setFontSize(11);
                } else if (size == 20) {
                    editor.setFontSize(20);
                } else if (size == 25) {
                    editor.setFontSize(25);
                } else if (size == 30) {
                    editor.setFontSize(30);
                } else if (size == 35) {
                    editor.setFontSize(35);
                }
            });
        }

        function executeCode() {

            $.ajax({

                url: "./ide/teacher-compiler_run.php?file_id=<?php echo $file_id?>",

                method: "POST",

                data: {
                    language: $("#languages").val(),
                    code: editor.getSession().getValue()
                },

                success: function (response) {
                    $(".output").text(response)
                }
            })
        }
    </script>


</body>

</html>