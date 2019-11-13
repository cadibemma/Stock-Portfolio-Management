<?php

$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
    die('Could not connect to MySQL database: ' . mysql_error());
}

$username = $_POST['username'];
$portfolioname = $_POST['portfolioname'];

$sql= "DELETE FROM portfolio WHERE username = '$username' and portfolio_name = '$portfolioname'";
$sqlC = "DELETE FROM cash WHERE username = '$username' and portfolio_name = '$portfolioname'";
$sqlO = "DELETE FROM overview WHERE username = '$username' and portfolio_name = '$portfolioname'";
$sqlP = "DELETE FROM performance WHERE username = '$username' and portfolio_name = '$portfolioname'";
$sqlT = "DELETE FROM transaction WHERE username = '$username' and portfolio_name = '$portfolioname'";

if ($conn->query($sql) === TRUE && $conn->query($sqlC) === TRUE && $conn->query($sqlO) === TRUE && $conn->query($sqlP) === TRUE &&$conn->query($sqlT) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();


?>