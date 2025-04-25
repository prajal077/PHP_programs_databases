<?php
$conn = new mysqli ("localhost", "root", "", "student_db");
if($conn -> connect_error) {
    die("Connection error".$conn -> connect_error);
}

echo "Connection successfull";
echo "<br>";

$sql = "UPDATE std SET email = 'prajalUpdate@gmail.com' where id = 1 ";

if($conn -> query($sql) == TRUE) {
    echo "data updated successfully";
}
else {
    echo "data is not updated", $conn -> error ;
}

$conn -> close() ;
?>