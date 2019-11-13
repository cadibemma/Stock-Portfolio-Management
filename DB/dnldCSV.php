<?php

$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

$conn = new mysqli($servername, $username, $password, $dbname);
//echo "Testing CSV";

if($conn->connect_error) {
    die('Could not connect to MySQL database: ' . $conn->connect_error);
}

$username = $_POST['username'];
$portfolio_name = $_POST['portfolioname'];

// username and portfolioname
$sql = "SELECT * FROM performance WHERE username = '$username' and portfolio_name = '$portfolio_name'";

$result = $conn->query($sql);

if($result->num_rows > 0) {
    $delimeter = ",";
    $filename = strtoupper($portfolio_name).'_' . date('Y-m-d').'.csv';
//echo $filename;

    // get file pointer
    $pointer = fopen('php://memory', 'w');

    // set column headers
    $columns = array('SYMBOL', 'COMPANY NAME', 'BUY PRICE', 'BUY DATE', 'SHARES', 'CURRENT PRICE', 'CURRENCY', 'GAIN/LOSS', 'NET ASSET VALUE');
    fputcsv($pointer, $columns, $delimeter);

    // username, portfolio_name, symbol, company_name, buy_price, buy_date, shares, current_price, currency, gain_loss, port_nav
    while($row = $result->fetch_assoc()) {
        //echo $row["symbol"];
        $line = array($row["symbol"], $row["company_name"], $row["buy_price"], $row["buy_date"], $row["shares"], $row["current_price"], $row["currency"], $row["gain_loss"], $row["port_nav"]);
        fputcsv($pointer, $line, $delimeter);
    }

    fseek($pointer, 0);

    /*header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=" '.$filename.' "; ');*/

    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename='.$filename.'');
    echo "\xEF\xBB\xBF";

    fpassthru($pointer);

}

exit();