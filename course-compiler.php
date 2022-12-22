<?php
include_once("./database/config.php");
session_start();

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$image=$_SESSION['image'];

$course_id=$_GET['course_id'];
$lesson_id=$_GET['lesson_id'];

$sql = "SELECT * FROM course_lessons WHERE `course_id`='$course_id' AND `lesson_id`='$lesson_id'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
        
$filename = $row['lesson_no'];
$lesson_title = $row['lesson_title'];
$lesson_Instructions = $row['lesson_Instructions'];
$lesson_code_sample = $row['lesson_code_sample'];
$lesson_output = $row['lesson_output'];
$filetype = $row['language'];

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
if($filetype=="node"){
    $icon = "images/icons/node.png";
    $com_lang = "node";
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
    <title>Course Compiler</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="../dashboard/css/simplebar.css">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icons CSS -->
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

<body class="horizontal light  ">
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white flex-row border-bottom shadow"
            style="padding-left:50px;padding-right:50px;">
            <div class="container-fluid">
                <div class="d-flex">
                    <div>
                        <a class="navbar-brand mx-lg-1 mr-0" href="users/course-profile.php?course_id=<?php echo $course_id?>">
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
                        <a class="nav-link pr-0" href="#" id="navbarDropdownMenuLink"
                            style="color:#222; font-weight:600;">
                            <span class="avatar avatar-sm mt-2"><?php echo $filename." .".$filetype?></span>
                            <img src="<?php echo $icon ?>" alt="Python" width="28px;" height="28px;"
                                style="margin-left:7px;">
                        </a>
                    </div>
                </div>
                <div style="margin-left:10%;">
                    <button class="btn btn-primary" onclick="executeCode();">
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
                                <option value="<?php echo $com_lang?>"> <?php echo $filetype?></option>
                            </select>
                            <select id="course_id" class="course_id" hidden>
                                <option value="<?php echo $course_id?>"> <?php echo $course_id?></option>
                            </select>
                            <select id="lesson_id" class="lesson_id" hidden>
                                <option value="<?php echo $lesson_id?>"> <?php echo $lesson_id?></option>
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
                                        <img src="./images/users/<?php echo $image?>" alt="..."
                                            class="avatar-img rounded-circle">
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <li class="nav-item">
                                        <a class="nav-link pl-3" href="users/profile.php">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pl-3" href="users/security.php">Security</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pl-3" href="users/logout.php">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>

        <main role="main" class="main-content" style="padding:0; margin:0;">
            <div class="container-fluid">
                <div class="row justify-content-center" style="height: 91.3vh;">

                    <div class="col-4" style="height: 91.3vh;overflow-y: scroll;">
                        <div style="padding:20px 10px;">
                            <h4 style="padding-top:5px;font-size:26px;">Learn</h4>
                            <hr>
                        </div>
                        <div>
                            
                        </div>
                        <div style="padding:0 10px;">
                            <h2><?php echo $lesson_title?></h2>
                            <hr>
                            <p style="font-size:15px;"><?php echo $lesson_Instructions?></p>
                            <div class="code-area">
                                <pre class="code-box"><?php echo $lesson_code_sample?></pre>
                            </div>
                        </div>
                        <hr>
                        <div style="padding:0 10px;">
                            <h3>Expected Output</h3>
                            <hr>
                            <p>When you run your program your complier should print the following result,</p>
                            <div class="code-area">
                                <pre class="code-box"><?php echo $lesson_output?></pre>
                            </div>
                            <p>Note: Output has to be exactly the same otherwise the system will detect the lesson as incomplete</p>
                        </div>
                        <div class="result"></div>
                    </div>
                    <div class="editor col-4" id="editor" style="height: 91.3vh; overflow:auto;"></div>
                    <div class="output col-4"
                        style="font-family: Courier New, Courier, monospace; color:white; background:#222;padding:20px;height: 91.3vh; overflow:auto;">
                    </div>
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

                url: "./ide/course_compiler_run.php",

                method: "POST",

                data: {
                    language: $("#languages").val(),
                    code: editor.getSession().getValue(),
                    course_id: $("#course_id").val(),
                    lesson_id: $("#lesson_id").val()
                },

                success: function (response) {
                    $(".output").text(response)
                }
                
            })
        }
    </script>


</body>

</html>