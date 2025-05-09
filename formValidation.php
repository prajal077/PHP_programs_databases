<form action="" method = "POST">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name"> <br> <br>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email">
    </div> <br> <br>
    <button type="submit">submit</button>  
</form>

<?php

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];

    if(empty($name) || empty($email)) {
        $error = "name or email cannot be empty";
        echo $error;
    } 
    else {
        $conn = new mysqli("localhost", "root", "", "student_db");

        if($conn -> connect_error) {
            die("Connection error".$conn -> connect_error);
        }
        else {

            echo "connection successfull";
            $res = $conn -> query("SELECT name, email FROM std WHERE name = '$name' AND email = '$email'");
            $user = $res -> fetch_assoc();

            print_r($user);

            if($user) {
                session_start();
                $_SESSION['name'] = $name;
                header("Location: dashboard.php");
                exit();
            }

        }
        
        $conn -> close();
    }
}
?>