<?php
$conn = new mysqli ("localhost", "root", "", "student_db");
if($conn -> connect_error) {
    die("Connection error".$conn -> connect_error);
}

echo "Connection successfull";
echo "<br>";

$sql = "INSERT INTO std (name, email) VALUES ('prajal', 'prajal1@gmail.com') ";

if($conn -> query($sql) == TRUE) {
    echo "data inserted successfully";
}
else {
    echo "data is not inserted", $conn -> error ;
}

$conn -> close() ;
?>