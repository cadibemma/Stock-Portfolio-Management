<?php

$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

$conn = new mysqli($servername, $username, $password, $dbname);

// username and portfolioname

if(! $conn ) {
    die('Could not connect to MySQL database: ' . mysql_error());
}

$username = $_POST['username'];
$portfolio_name = $_POST['portfolioname'];

//portfolio_name, username, company_name, symbol, type, timestamp, shares, price, amount
$transactionSQL = "SELECT * FROM transaction WHERE username = '$username' and portfolio_name = '$portfolio_name'";

function getTransactionData($conn, $transactionSQL) {
    $result = $conn->query($transactionSQL);
    $transaction_data = array();
    if ($result->num_rows > 0) {
        //echo "FOUND TRANSACTION DATA FOR USER";
        while($row = $result->fetch_assoc()) {
            array_push($transaction_data, $row["company_name"], $row["symbol"], $row["type"], $row["timestamp"], $row["shares"], $row["price"], $row["amount"]);

        }

    } else {
       //echo "RECORD NOT FOUND - FIRST TIME STOCK BUYER";
    }

    $json = json_encode($transaction_data);
    return $json;

}

echo getTransactionData($conn, $transactionSQL);