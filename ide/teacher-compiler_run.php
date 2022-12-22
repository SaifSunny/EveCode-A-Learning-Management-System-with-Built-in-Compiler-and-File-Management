<?php
include_once("../database/config.php");
session_start();

$username = $_SESSION['teachername'];

    $language = strtolower($_POST['language']);
    $code = $_POST['code'];
    $file_id=$_GET['file_id'];

    $sql = "SELECT * FROM teacher_files WHERE `file_id`='$file_id'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
            
    $filename = $row['filename'];
    $filetype = $row['filetype'];

    $filePath = $username."/".$filename.".".$filetype;
    $programFile = fopen($filePath, "w");
    fwrite($programFile, $code);
    fclose($programFile);



    if($filetype == "php") {
        $output = shell_exec("C:\php-8.1.8\php.exe C:/xampp/htdocs/EveCode/ide/$filePath 2>&1");
        echo $output;
    }
    if($filetype == "python") {
        $output = shell_exec("C:\Python310\python.exe C:/xampp/htdocs/EveCode/ide/$filePath 2>&1");
        echo $output;
    }
    if($filetype == "node.js") {
        $output = shell_exec("C:/nodejs/node.exe C:/xampp/htdocs/EveCode/ide/$filePath 2>&1");
        echo $output;
    }
    if($filetype == "c") {
        $outputExe = $username."/".$filename.".exe";
        echo shell_exec("C:\MinGW\bin\gcc.exe C:/xampp/htdocs/EveCode/ide/$filePath -o C:/xampp/htdocs/EveCode/ide/$outputExe");
        $output = shell_exec("C:/xampp/htdocs/EveCode/ide/$outputExe");
        echo $output;
    }
    if($filetype == "cpp") {
        $outputExe = $filename . ".exe";
        shell_exec("C:\MinGW\bin\g++.exe C:/xampp/htdocs/EveCode/ide/$filePath -o C:/xampp/htdocs/EveCode/ide/$outputExe");
        $output = shell_exec("C:/xampp/htdocs/EveCode/ide/$outputExe");
        echo $output;
    }
    
