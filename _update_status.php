<?php
include 'connection.php';

$status = $_POST['status'];
$id = $_POST['id'];

$sql = "UPDATE a_project SET `status` = '$status' where `id` = '$id'";
$res = mysqli_query($con,$sql);

if($res){
        echo 1;
}else{
    echo 0;
}