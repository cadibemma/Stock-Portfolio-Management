<?php
$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// escape variables for security
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);

$sql="INSERT INTO user (username, password, firstname, lastname)
VALUES ('$username', '$password', '$firstname', '$lastname');";

if (!mysqli_query($conn, $sql)) {
    die('Error: ' . mysqli_error($conn));
}
echo "Account created! Now you may Login";

mysqli_close($conn);