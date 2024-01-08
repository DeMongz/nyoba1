<?php 
$con = mysqli_connect("localhost","root","mysql12","muhammaddzaki");

//check connection
if(mysqli_connect_errno()){
    die("Gagal Konek ke MySQL : " .mysqli_connect_error());
}
?>