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
            $username = htmlspecialchars($_POST["username"]); // htmlspecialchars Protects your site from Cross-Site Scripting (XSS) attacks.
                                                                //✅ It makes user input safe to display on the page.
            $password = htmlspecialchars($_POST["password"]);

            if (empty($username) || empty($password)) {
                $error = "username and password required";
                echo $error;  // Optional: show error
            } else {
                $conn = new mysqli("localhost", "root", "", "student_db");

                $res = $conn->query("SELECT id, username, password FROM std WHERE username = '$username'");

                $users = $res->fetch_assoc(); //fetch_assoc() takes one row from that result as an associative array (key-value pairs).
                print_r($users);

                if ($users && $password == $users['password']) {   //If user is found AND password matches, then log in.
                    session_start();
                    $_SESSION['username'] = $username;  //session id create garcha ra tesma user ko information rakcha.
                    header("Location: dashboard.php"); // move to the location dahsboard.php
                    exit();  // stop the php script
                }
            }
            $conn->close();
        }
        

        /*🔵 Why do we start a session in PHP?
        ✅ Session = a way to remember the user across different pages.

        When someone logs in, we need to keep them logged in when they move from one page to another (like from login → dashboard → profile → settings).
        Sessions help to do this. */
    ?>
</body>



//
</html>
