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

$sql = "SELECT portfolio_name FROM portfolio WHERE username = '$username'";
$result = $conn->query($sql);

function getPortfolios($conn, $result) {

$portfolio_names = array();
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        array_push($portfolio_names, $row["portfolio_name"]);
        //$portfolio_names = $row;
    }
}else {
        echo "NONE";
    }

    //print_r($portfolio_names);

    $conn->close();
    $json = json_encode($portfolio_names);
    return $json;
}
echo getPortfolios($conn, $result);
?>
