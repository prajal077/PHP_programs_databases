<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
</head>
<body>
    <h1>Welcome to my website</h1>
    <br>
    <form action="" method="POST">
        username <input type="text" name="username">
        password <input type="text" name="password">
        <button type="submit">submit</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = htmlspecialchars($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);

            if (empty($username) || empty($password)) {
                $error = "username and password required";
                echo $error;  // Optional: show error
            } else {
                $conn = new mysqli("localhost", "root", "", "student_db"); // Added missing semicolon here

                $res = $conn->query("SELECT id, username, password FROM std WHERE username = '$username'"); // Fixed quotes

                $users = $res->fetch_assoc();
                print_r($users);

                if ($users && $password == $users['password']) {
                    session_start();
                    $_SESSION['username'] = $username;
                    header("Location: dashboard.php"); // Corrected header syntax
                    exit();
                }
            }
            $conn->close();
        }
    ?>
</body>
</html>