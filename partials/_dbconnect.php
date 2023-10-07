<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "Users";
$connection = mysqli_connect($server,$username,$password,$database);
if(!$username){
  die("Eror: ").mysqli_connect_error();
}
?>