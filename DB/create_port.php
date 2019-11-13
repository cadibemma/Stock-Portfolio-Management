<?php
$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_POST['username'];
$portfolioname = $_POST['portfolioname'];
$newname = $_POST['newname'];
$type = $_POST['type'];

if($type === 'create'){
    $sql = "INSERT INTO portfolio (username, portfolio_name) VALUES ('$username', '$portfolioname')";

    if ($conn->query($sql) === TRUE) {
        echo "Portfolio created successfully";
    } else {
        die ("Could not create portfolio: " . $conn->error);
    }
}
if($type === 'rename'){
    $sql = "UPDATE portfolio SET portfolio_name='$newname' WHERE username ='$username' AND portfolio_name='$portfolioname'";
    $sqlC = "UPDATE cash SET portfolio_name='$newname' WHERE username ='$username' AND portfolio_name='$portfolioname'";
    $sqlO = "UPDATE overview SET portfolio_name='$newname' WHERE username ='$username' AND portfolio_name='$portfolioname'";
    $sqlP = "UPDATE performance SET portfolio_name='$newname' WHERE username ='$username' AND portfolio_name='$portfolioname'";
    $sqlT = "UPDATE transaction SET portfolio_name='$newname' WHERE username ='$username' AND portfolio_name='$portfolioname'";

    if ($conn->query($sql) === TRUE && $conn->query($sqlC) === TRUE && $conn->query($sqlO) === TRUE && $conn->query($sqlP) === TRUE &&$conn->query($sqlT) === TRUE) {
        echo "Portfolio updates successfully";
    } else {
        die ("Could not create portfolio: " . $conn->error);
    }
}
