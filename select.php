<?php
$conn = new mysqli ("localhost", "root", "", "student_db");
if($conn -> connect_error) {
    die("Connection error".$conn -> connect_error);
}

echo "Connection successfull";
echo "<br>";

$sql = "SELECT id, name, email FROM std where id = 4 ";

$res = $conn -> query($sql);
//print_r($res > fetch_assoc());


if ($res->num_rows > 0) {
    foreach ($res as $row) {
        echo "ID: {$row['id']} - Name: {$row['name']} - Email: {$row['email']}<br>";
    }
} else {
    echo "0 results";
}



//         <-- IN TABLE FORMAT -->

// if ($res->num_rows > 0) {
//     // Output in table format
//     echo "<table border='1' cellpadding='5' cellspacing='0'>
//             <tr>
//                 <th>ID</th>
//                 <th>Name</th>
//                 <th>Email</th>
//             </tr>";

//     while ($row = $res->fetch_assoc()) {
//         echo "<tr>
//                 <td>{$row['id']}</td>
//                 <td>{$row['name']}</td>
//                 <td>{$row['email']}</td>
//               </tr>";
//     }

//     echo "</table>";
// } else {
//     echo "No records found.";
// }

$conn->close();
?>