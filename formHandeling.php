<form action="" method="POST">
    Name: <input type="text" name="name" placeholder="Enter name"><br><br>
    Email: <input type="text" name="email" placeholder="Enter email"><br><br>
    <input type="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST["name"];
    $email = $_POST["email"];

    $conn = new mysqli("localhost", "root", "", "student_db");

    if ($conn->connect_error) {
        die("Connection error: " . $conn->connect_error);
    }

    echo "Connection successful<br>";

    $sql = "INSERT INTO std (name, email) VALUES ('$name', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Data insertion failed: " . $conn->error;
    }

    $conn->close();
}
?>
