<?php
include 'connection.php';

if(isset($_POST["Import"])){

    $filename=$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
            $sql = "INSERT INTO `a_project`(`category_id`, `name`, `status`,`client_amount`, `client_name`, `client_tax`, `govt_tax`, `net_amount`) 
                    VALUES ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."')";
            $result = mysqli_query($con, $sql);
        }

        header('Location: project.php');
        exit();

        fclose($file);
    }
}
?>
