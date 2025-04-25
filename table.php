<?php
$conn = new mysqli ("localhost", "root", "", "student_db");
if($conn -> connect_error) {
    die("Connection error".$conn -> connect_error);
}

echo "Connection successfull";
echo "<br>";

$sql = "CREATE TABLE std (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20), email VARCHAR(20) UNIQUE)" ;

if($conn -> query($sql) == TRUE) {
    echo "table created successfully";
}
else {
    echo "Table is not created", $conn -> error ;
}

$conn -> close() ;


?>