<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Compiler</title>
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

<body class="horizontal light">
    <div class="wrapper">

        <main role="main" class="main-content" style="padding:0; margin:0;">

            <div class="d-flex justify-content-between" style="padding:10px 50px;">
                <div>
                    <a class="navbar-brand mx-lg-1 mr-0" href="./index.php">
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
                <div class="control-panel" style="padding-top:10px;">
                    Theme:
                    <select id="themename" class="themename" onchange="changetheme()">
                        <option value="monokai"> Monokai </option>
                        <option value="nord_dark"> Nord_dark </option>
                        <option value="eclipse"> Eclipse </option>
                        <option value="solarized_dark"> Solarized_dark </option>
                        <option value="solarized_light"> Solarized_light </option>
                        <option value="kr_theme"> Kr_theme </option>
                    </select>
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
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
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    Language:
                    <select id="languages" class="languages" onchange="changeLanguage()">
                        <option value="c"> C </option>
                        <option value="cpp"> C++ </option>
                        <option value="php"> PHP </option>
                        <option value="python"> Python </option>
                        <option value="node"> Node JS </option>
                    </select>
                    &nbsp;
                </div>
                <div style="padding-top:3px;padding-right:30px;">
                    <button class="btn btn-primary" onclick="executeCode();">Run </button> &nbsp;
                </div>
            </div>

            <div class="container-fluid">
                <div class="row justify-content-center" style="">
                    <div class="editor col-8" id="editor" style="height: 91.2vh; overflow:auto;font-size:20px;"></div>
                    <div class="output col-4"
                        style="font-family: Courier New, Courier, monospace; color:white; background:#222;padding:20px;">
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


    <script src="home/js/lib/ace.js"></script>
    <script src="home/js/lib/theme-monokai.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        let editor;

        window.onload = function () {
            editor = ace.edit("editor");
            editor.setTheme("ace/theme/monokai");
            editor.session.setMode("ace/mode/c_cpp");
        }

        function changetheme() {
            var themename = $("#themename").val();
            editor = ace.edit("editor");
            editor.setTheme("ace/theme/" + themename);
        }

        function changeLanguage() {

            let languege = $("#languages").val();

            if (languege == 'c' || languege == 'cpp') editor.session.setMode("ace/mode/c_cpp");
            else if (languege == 'php') editor.session.setMode("ace/mode/php");
            else if (languege == 'py') editor.session.setMode("ace/mode/python");
            else if (languege == 'node') editor.session.setMode("ace/mode/javascript");
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

                url: "./ide/free_compiler_run.php",

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