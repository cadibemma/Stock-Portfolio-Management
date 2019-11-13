<?php

$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

$conn = new mysqli($servername, $username, $password, $dbname);

if(! $conn ) {
    die('Could not connect to MySQL database: ' . mysql_error());
}

$type = $_POST['type'];
$amount = $_POST['amount'];
$username = $_POST['username'];
$portfolio_name = $_POST['portfolioname'];

$depositSQL = "INSERT INTO cash (username, portfolio_name, amount) VALUES ('$username', '$portfolio_name', '$amount')";
$withdrawSQL = "SELECT * FROM cash WHERE username = '$username' and portfolio_name = '$portfolio_name'";

if ($type == "deposit") {
    deposit($conn, $depositSQL, $withdrawSQL, $amount, $username, $portfolio_name);
} else {
    withdraw($conn, $withdrawSQL, $amount, $username, $portfolio_name);
}

function deposit($conn, $depositSQL, $withdrawSQL, $amount, $username, $portfolio_name) {
    $result = $conn->query($withdrawSQL);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        print_r($row);
        $actual = $row["amount"];
        $final = $actual + $amount;

        echo "user added amount " . $amount . "<br>";
        echo "database has amount " . $actual ."<br>";


        $sql = "UPDATE cash SET amount='$final' WHERE username = '$username' and portfolio_name = '$portfolio_name'";
        $sqlT = "INSERT INTO transaction (portfolio_name, username, company_name, symbol, type, timestamp, shares, price, amount) VALUES('$portfolio_name','$username',NULL, NULL, 'Deposit', NOW(), NULL,NULL, '$amount')";

        if ($conn->query($sql) === TRUE && $conn->query($sqlT) === TRUE) {
            echo  "deposit completed successfully";
        } else {
            die ("Could not perform deposit: " . $conn->error);
        }


    } else {
        if ($conn->query($depositSQL) === TRUE) {
            echo "added cash successfully";
        } else {
            die ("Could not add cash: " . $conn->error);
        }
    }
}

function withdraw($conn, $withdrawSQL, $amount, $username, $portfolio_name) {
    $result = $conn->query($withdrawSQL);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        //print_r($row);
        $actual = $row["amount"];

        //echo "user requested for amount " . $amount . "<br>";
        //echo "database has amount " . $actual ."<br>";

        if (min($amount, $actual) === $amount) {
            $final = $actual - $amount;
            $sql = "UPDATE cash SET amount='$final' WHERE username = '$username' and portfolio_name = '$portfolio_name'";

            $amount = -$amount;
            $sqlT = "INSERT INTO transaction (portfolio_name, username, company_name, symbol, type, timestamp, shares, price, amount) VALUES('$portfolio_name','$username',NULL, NULL, 'Withdrawal', NOW(), NULL,NULL, '$amount')";
            if ($conn->query($sql) === TRUE && $conn->query($sqlT) === TRUE) {
                echo  "withdrawal completed successfully";
            } else {
                die ("Could not perform withdrawal: " . $conn->error);
            }

        } else {
            echo "REQUESTED AMOUNT EXCEEDS AMOUNT AVAILABLE";
        }

    } else {
        echo "RECORD NOT FOUND IN DATABASE, UGGHHH";
    }

}