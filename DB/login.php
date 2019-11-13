<?php

session_start();

$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// escape variables for security
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);


$sql = "SELECT * FROM user WHERE username = '$username' and password = '$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    ///echo "found result";
    $row = mysqli_fetch_assoc($result);
    //echo "username: " . $row["username"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";

    $_SESSION['username'] = $row["username"];
    $_SESSION['name'] = $row["firstname"]. " " . $row["lastname"];

    echo "Login Success";

} else {
    echo "Invalid Username / Password";
}

mysqli_close($conn);