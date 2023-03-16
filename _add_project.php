<?php
include 'connection.php';

$category = $_POST['category'];
$name = $_POST['project_name'];
$status = $_POST['status'];
$project_assign = $_POST['project_assign'];
$clint_name = $_POST['clint_name'];
$clint_amount = $_POST['clint_amount'];
$clint_tax = $_POST['clint_tax'];
$govt_tax = $_POST['govt_tax'];
$net_amount=( (int)$clint_amount + (float)$clint_tax ) - (float)$govt_tax;


$sql = "INSERT INTO `a_project`(`category_id`, `name`, `clint_name`,`clint_amount`, `clint_tex`, `govt_tax`, `net_amount`, `status`)
        VALUES ('$category','$name','$clint_name','$clint_amount','$clint_tax','$govt_tax','$net_amount','$status')";
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