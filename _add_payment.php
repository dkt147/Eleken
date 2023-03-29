<?php
include 'connection.php';

$rp_name = $_POST['rp_name'];
$mode = $_POST['mode'];
$bank = $_POST['bank'] == '' ? '' : $_POST['bank'] ;
$cash = $_POST['cash'];
$cheque = $_POST['cheque'] == '' ? '' : $_POST['cheque'];
$column = ($_POST['mode'] == 'cash' ? 'cash_amount' : 'amount');


$month = date("m");
$year = date("Y");
$sql = "INSERT INTO `a_receivings`(`project_id`, `mode`, `bank_name`, `cheque_no`,`$column`,`month`,`year`) 
VALUES('$rp_name','$mode','$bank','$cheque','$cash','$month','$year')";
$res = mysqli_query($con,$sql);

if($res){
        echo 1;
}else{
    echo 0;
}