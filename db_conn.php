<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "shen_db";

@$cn = new mysqli($servername, $username, $password, $database);

if($cn->connect_error){
    die("Connection failed: ". $cn->connect_error);

}

?>
