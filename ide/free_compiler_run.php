<?php
    $language = strtolower($_POST['language']);
    $code = $_POST['code'];

    $random = substr(md5(mt_rand()), 0, 7);
    $filePath = "temp/" . $random . "." . $language;
    $programFile = fopen($filePath, "w");
    fwrite($programFile, $code);
    fclose($programFile);

    if($language == "php") {
        $output = shell_exec("C:\php-8.1.8\php.exe C:/xampp/htdocs/EveCode/ide/$filePath 2>&1");
        echo $output;
    }
    if($language == "python") {
        $output = shell_exec("C:\Python310\python.exe C:/xampp/htdocs/EveCode/ide/$filePath 2>&1");
        echo $output;
    }
    if($language == "node") {
        rename($filePath, $filePath.".js");
        $output = shell_exec("C:/nodejs/node.exe C:/xampp/htdocs/EveCode/ide/$filePath.js 2>&1");
        echo $output;
    }
    if($language == "c") {
        $outputExe = $random . ".exe";
        shell_exec("C:\MinGW\bin\gcc.exe C:/xampp/htdocs/EveCode/ide/$filePath -o C:/xampp/htdocs/EveCode/ide/temp/$outputExe");
        $output = shell_exec("C:/xampp/htdocs/EveCode/ide/temp/$outputExe");
        echo $output;
    }
    if($language == "cpp") {
        $outputExe = $random . ".exe";
        shell_exec("C:\MinGW\bin\g++.exe C:/xampp/htdocs/EveCode/ide/$filePath -o C:/xampp/htdocs/EveCode/ide/temp/$outputExe");
        $output = shell_exec("C:/xampp/htdocs/EveCode/ide/temp/$outputExe");
        echo $output;
    }