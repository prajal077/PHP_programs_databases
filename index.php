<?php
// Database connection settings
$servername = "localhost";
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "task_manager";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission (Add Task)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task"])) {
    // Get task from form and sanitize
    $task = $conn->real_escape_string($_POST["task"]);
    
    // Insert task into database
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    
    if ($conn->query($sql) === TRUE) {
        // Set success message
        $success_message = "Task added successfully!";
    } else {
        // Set error message
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Process delete request
if (isset($_GET["delete"])) {
    // Get and sanitize ID
    $id = $conn->real_escape_string($_GET["delete"]);
    
    // Delete task from database
    $sql = "DELETE FROM tasks WHERE id = '$id'";
    
    if ($conn->query($sql) === TRUE) {
        // Set success message
        $success_message = "Task deleted successfully!";
    } else {
        // Set error message
        $error_message = "Error deleting task: " . $conn->error;
    }
    
    // Redirect to remove the query parameter
    header("Location: index.php");
    exit();
}

// Fetch all tasks
$sql = "SELECT * FROM tasks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Task Manager</title>
    <style>
        /* CSS styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: #555;
            margin-bottom: 15px;
        }

        form {
            display: flex;
            margin-bottom: 30px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
        }

        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .task-list {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
        }

        ul {
            list-style-type: none;
        }

        li {
            padding: 12px 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        li:last-child {
            border-bottom: none;
        }

        .timestamp {
            color: #999;
            font-size: 12px;
            margin: 0 10px;
        }

        .delete-btn {
            color: #ff4444;
            text-decoration: none;
            font-size: 14px;
        }

        .delete-btn:hover {
            text-decoration: underline;
        }

        .error {
            border: 1px solid #ff4444;
        }
        
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        
        .error-message {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Task Manager</h1>
        
        <?php if(isset($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if(isset($error_message)): ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <!-- Task Form -->
        <form id="task-form" method="POST" action="index.php">
            <input type="text" id="task" name="task" placeholder="Enter a new task..." required>
            <button type="submit">Add Task</button>
        </form>
        
        <!-- Task List -->
        <div class="task-list">
            <h2>Your Tasks</h2>
            <?php if($result->num_rows > 0): ?>
                <ul>
                <?php while($row = $result->fetch_assoc()): ?>
                    <li>
                        <?php echo htmlspecialchars($row["task"]); ?>
                        <span class="timestamp"><?php echo date('M j, Y, g:i a', strtotime($row["created_at"])); ?></span>
                        <a href="index.php?delete=<?php echo $row["id"]; ?>" class="delete-btn">Delete</a>
                    </li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No tasks yet. Add a task above!</p>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        // JavaScript for form validation
        document.addEventListener('DOMContentLoaded', function() {
            // Get the task form
            const taskForm = document.getElementById('task-form');
            const taskInput = document.getElementById('task');
            
            // Add submit event listener
            taskForm.addEventListener('submit', function(event) {
                // Get task value and trim whitespace
                const taskValue = taskInput.value.trim();
                
                // Validate task
                if (taskValue === '') {
                    // Prevent form submission
                    event.preventDefault();
                    
                    // Add error class to input
                    taskInput.classList.add('error');
                    
                    // Alert user
                    alert('Please enter a task!');
                } else if (taskValue.length < 3) {
                    // Prevent form submission
                    event.preventDefault();
                    
                    // Add error class to input
                    taskInput.classList.add('error');
                    
                    // Alert user
                    alert('Task must be at least 3 characters long!');
                } else {
                    // Remove error class if previously added
                    taskInput.classList.remove('error');
                }
            });
            
            // Remove error class when typing
            taskInput.addEventListener('input', function() {
                taskInput.classList.remove('error');
            });
        });
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>