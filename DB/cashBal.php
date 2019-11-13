<?php

$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

$conn = new mysqli($servername, $username, $password, $dbname);

if(! $conn ) {
    die('Could not connect to MySQL database: ' . mysql_error());
}


$username = $_POST['username'];
$portfolioname = $_POST['portfolioname'];

$sql = "SELECT * FROM cash WHERE username = '$username' and portfolio_name = '$portfolioname'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$actual = $row["amount"];
echo $actual;

