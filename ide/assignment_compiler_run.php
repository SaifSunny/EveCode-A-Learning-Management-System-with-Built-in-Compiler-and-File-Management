<?php
include_once("../database/config.php");
session_start();

    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    $language = strtolower($_POST['language']);
    $code = $_POST['code'];
    $course_id = $_POST['course_id'];
    $assignment_id = $_POST['assignment_id'];

    $sql = "SELECT * FROM course_assignments WHERE `course_id`='$course_id' AND `assignment_id`='$assignment_id'";
    $result = mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
            
    $assignment_output = $row['assignment_output'];


    $random = substr(md5(mt_rand()), 0, 7);
    $filePath = "temp/" . $random . "." . $language;
    $programFile = fopen($filePath, "w");
    fwrite($programFile, $code);
    fclose($programFile);
    $date= date('Y-m-d H:i');

    

    if($language == "php") {
        $output = shell_exec("C:\php-8.1.8\php.exe C:/xampp/htdocs/EveCode/ide/$filePath 2>&1");
        if((string)$assignment_output == (string)$output){
            $query = "SELECT * FROM course_assignment_complete WHERE user_id = '$user_id' AND assignment_id = '$assignment_id'";
            $query_run = mysqli_query($conn, $query);
            if(!$query_run->num_rows > 0){
                $sql = "INSERT INTO course_assignment_complete(assignment_id,user_id,submit) values('$assignment_id','$user_id','$date')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo "You have Successfully Completed The assignment.";
                }
            }
        }
        echo $output;
    }
        if($language == "python") {
            $output = shell_exec("C:\Python310\python.exe C:/xampp/htdocs/EveCode/ide/$filePath 2>&1");

            if((string)$assignment_output == (string)$output){
                $query = "SELECT * FROM course_assignment_complete WHERE user_id = '$user_id' AND assignment_id = '$assignment_id'";
                $query_run = mysqli_query($conn, $query);
                if(!$query_run->num_rows > 0){

                    $sql = "INSERT INTO course_assignment_complete(assignment_id,user_id,submit) values('$assignment_id','$user_id','$date')";
                    $result = mysqli_query($conn, $sql);
                    if($result){
                        echo "You have Successfully Completed The assignment.";

                    }
                }
            }else{
                echo $output;

            }
            echo $output;
        }

    
    if($language == "node") {
        rename($filePath, $filePath.".js");
        $output = shell_exec("C:/nodejs/node.exe C:/xampp/htdocs/EveCode/ide/$filePath.js 2>&1");
        if((string)$assignment_output == (string)$output){
            $query = "SELECT * FROM course_assignment_complete WHERE user_id = '$user_id' AND assignment_id = '$assignment_id'";
            $query_run = mysqli_query($conn, $query);
            if(!$query_run->num_rows > 0){

                $sql = "INSERT INTO course_assignment_complete(assignment_id,user_id,submit) values('$assignment_id','$user_id','$date')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo "You have Successfully Completed The assignment.";

                }
            }
        }
        echo $output;
    }
    if($language == "c") {
        $outputExe = $random . ".exe";
        shell_exec("C:\MinGW\bin\gcc.exe C:/xampp/htdocs/EveCode/ide/$filePath -o C:/xampp/htdocs/EveCode/ide/temp/$outputExe");
        $output = shell_exec("C:/xampp/htdocs/EveCode/ide/temp/$outputExe");
        if((string)$assignment_output == (string)$output){
            $query = "SELECT * FROM course_assignment_complete WHERE user_id = '$user_id' AND assignment_id = '$assignment_id'";
            $query_run = mysqli_query($conn, $query);
            if(!$query_run->num_rows > 0){

                $sql = "INSERT INTO course_assignment_complete(assignment_id,user_id,submit) values('$assignment_id','$user_id','$date')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo "You have Successfully Completed The assignment.";

                }
            }
        }
        echo $output;
    }
    if($language == "cpp") {
        $outputExe = $random . ".exe";
        shell_exec("C:\MinGW\bin\g++.exe C:/xampp/htdocs/EveCode/ide/$filePath -o C:/xampp/htdocs/EveCode/ide/temp/$outputExe");
        $output = shell_exec("C:/xampp/htdocs/EveCode/ide/temp/$outputExe");
        if((string)$assignment_output == (string)$output){
            $query = "SELECT * FROM course_assignment_complete WHERE user_id = '$user_id' AND assignment_id = '$assignment_id'";
            $query_run = mysqli_query($conn, $query);
            if(!$query_run->num_rows > 0){

                $sql = "INSERT INTO course_assignment_complete(assignment_id,user_id,submit) values('$assignment_id','$user_id','$date')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo "You have Successfully Completed The assignment.";

                }
            }
        }
        echo $output;
    }