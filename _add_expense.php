<?php
include 'connection.php';

$ep_name = $_POST['ep_name'];
$eg_name = $_POST['eg_name'];
$e_event = $_POST['e_event'];
$e_amount = $_POST['e_amount'];

$sql = "INSERT INTO `a_expenses`(`project_id`, `group_id`, `event`, `amount`) VALUES ('$ep_name','$eg_name','$e_event','$e_amount')";
$res = mysqli_query($con,$sql);

if($res){
        echo 1;
}else{
    echo 0;
}