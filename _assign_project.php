<?php
include 'connection.php';

$p_id = $_POST['p_id'];
$group = $_POST['group'];

$sql = "INSERT INTO a_project_assign(`group_id`,`project_id`) VALUES('$group','$p_id')";
$res = mysqli_query($con,$sql);

if($res){
        echo 1;
}else{
    echo 0;
}