0<?php
if(isset($_GET['id'])){
    include 'connection.php';
    $id=$_GET['id'];
    $query="DELETE FROM `a_project` WHERE id='$id'";
    $res=mysqli_query($con,$query);
    header("Location:project.php");
}

?>