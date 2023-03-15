<?php
include 'connection.php';

$category = $_POST['category'];
$name = $_POST['name'];
$status = $_POST['status'];
$project_assign = $_POST['project_assign'];

$sql = "INSERT INTO a_project(`name`,`status`,`category_id`) VALUES('$name','$status','$category')";
$res = mysqli_query($con,$sql);

if($res){
    $sql = "SELECT * FROM a_project order by id desc";
    $res = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($res);
    $id = $row['id'];

    $sql = "INSERT INTO `a_project_assign`(`group_id`, `project_id`)  VALUES('$project_assign','$id')";
    $res = mysqli_query($con,$sql);

    if($res){
        echo 1;
    }else{
        echo 0;
    }

}else{
    echo 0;
}