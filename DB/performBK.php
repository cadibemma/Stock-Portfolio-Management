<?php

$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

$conn = new mysqli($servername, $username, $password, $dbname);

// username and portfolioname

if($conn->connect_error) {
    die('Could not connect to MySQL database: ' . $conn->connect_error);
}

$username = $_POST['username'];
$portfolio_name = $_POST['portfolioname'];

// username, portfolio_name, symbol, company_name, buy_price, buy_date, shares, current_price, currency, gain_loss, port_nav
$performanceSQL = "SELECT * FROM performance WHERE username = '$username' and portfolio_name = '$portfolio_name'";

function getPerformanceData($conn, $performanceSQL) {
    $result = $conn->query($performanceSQL);
    $performance_data = array();
    if ($result->num_rows > 0) {
        //echo "FOUND PERFROMANCE DATA FOR USER";

        while($row = $result->fetch_assoc()) {
            array_push($performance_data, $row["symbol"], $row["company_name"], $row["buy_price"], $row["buy_date"], $row["shares"], $row["current_price"], $row["currency"], $row["gain_loss"], $row["port_nav"]);
        }

    } else {
        //echo "PERFORMANCE DATA NOT FOUND";
    }

    $json = json_encode($performance_data);
    return $json;

}

echo getPerformanceData($conn, $performanceSQL);



?>