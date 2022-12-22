<?php
include_once("./database/config.php");

session_start();

if (!isset($_SESSION['teachername'])) {
    header("Location: teacher_login.php");
}

$teacher_id = $_SESSION['teacher_id'];
$image = $_SESSION['image'];
$username = $_SESSION['username'];

$filename= strtolower($_POST['name']);
$filetype= $_POST['lang'];

date_default_timezone_set('Asia/Dhaka');
$created = date('y-m-d h:i:s');

$sql = "SELECT * FROM teacher_files WHERE teacher_id='$teacher_id' AND `filename`='$filename' AND `filetype`='$filetype'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    echo"<script>
    alert('File Alrteady Exists');
    window.location.href='teachers/dashboard.php';
    </script>";

    echo $created;

}
else{

    $sql = "INSERT INTO teacher_files(`teacher_id`,`filename`, filetype, created ) VALUES ('$teacher_id','$filename','$filetype', '$created')";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        $dir_path = getcwd();
        $file_path = $dir_path."/ide"."/".$username;

        $sql = "SELECT `file_id` FROM teacher_files WHERE teacher_id='$teacher_id' AND `filename`='$filename' AND `filetype`='$filetype'";
        $result = mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($result);
        
        $file_id = $row['file_id'];
            
       $repo = fopen($file_path."/".$filename.".".$filetype, "a") or die("Unable to open file!");
    
        if($filetype == "c"){
    
            $txt = "#include <stdio.h>
    int main() {
    //Start Writing your Code
        
        
    return 0;
    }";
            fwrite($repo, $txt);
            fclose($repo);
            header("Location: ./teacher-compiler.php?file_id=$file_id");
        }
        elseif($filetype == "cpp"){
    
            $txt = "#include <iostream>
using namespace std;
    int main() {
    //Start Writing your Code
        
        
    return 0;
    }";
            fwrite($repo, $txt);
            fclose($repo);
            header("Location: ./teacher-compiler.php?file_id=$file_id");
    
        }
        elseif($filetype == "python"){
    
            $txt ="#Start Writing your Code";
            fwrite($repo, $txt);
            fclose($repo);
            header("Location: ./teacher-compiler.php?file_id=$file_id");
        }
        elseif($filetype == "php"){
            
            $txt = "<?php
//Start Writing your Code
    
                
?>";
            fwrite($repo, $txt);
            fclose($repo);
            header("Location: ./teacher-compiler.php?file_id=$file_id");
        }
        elseif($filetype == "node.js"){
            $txt = "//Start Writing your Code";
            fwrite($repo, $txt);
            fclose($repo);
            header("Location: ./teacher-compiler.php?file_id=$file_id");

        }
    }
}

?>