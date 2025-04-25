<?php
$conn = new mysqli ("localhost", "root", "");
if($conn -> connect_error) {
    die("Connection error".$conn -> connect_error);
}

echo "Connection successfull";
echo "<br>";

$sql = "CREATE DATABASE student_db";
$conn -> query($sql);


?>