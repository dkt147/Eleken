<?php
include 'connection.php';

$category = $_POST['category'];
$name = $_POST['project_name'];
$status = $_POST['status'];
$project_assign = $_POST['project_assign'];
$client_name = $_POST['client_name'];
$client_amount = $_POST['client_amount'];
$client_tax = $_POST['client_tax'];
$govt_tax = $_POST['govt_tax'];
$net_amount=( (int)$client_amount + (float)$client_tax ) - (float)$govt_tax;


$sql = "INSERT INTO `a_project`(`category_id`, `name`, `client_name`,`client_amount`, `client_tax`, `govt_tax`, `net_amount`, `status`)
        VALUES ('$category','$name','$client_name','$client_amount','$client_tax','$govt_tax','$net_amount','$status')";
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