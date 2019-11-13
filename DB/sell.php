<?php

include 'functions.php';

// 1. Query performance table with username n portfolioname to determine if user has adequate shares
// 2. If current-num-shares < num-shares, die()
// 3. If current-num-shares > num-shares, proceed to servlet for sell transaction

//header('Content-Type: application/json');

$symbol = isset($_GET['ticker']) ? $_GET['ticker'] : die();
$username = isset($_GET['username']) ? $_GET['username'] : die();
$portfolio_name = isset($_GET['portfolioname']) ? $_GET['portfolioname'] : die();
$requested_num_of_shares = isset($_GET['num_of_shares']) ? $_GET['num_of_shares'] : die();
$cost = isset($_GET['cost']) ? $_GET['cost'] : die();
$total_cost = isset($_GET['total_cost']) ? $_GET['total_cost'] : die();

$performance_query = "SELECT shares FROM performance WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol = '$symbol' ";

/*$current_num_of_shares = get_number_of_shares($conn, $performance_query);
if ($requested_num_of_shares > $current_num_of_shares) {
	http_response_code(400);
	echo json_encode(array("message" => "Requested number of shares is greater than current number of shares."));
	die("Requested number of shares is greater than current number of shares.");
} else {*/
	// go to servlet
	$curl = curl_init();
	$endpoint = "https://web.njit.edu/~cla22/webapps8/process";
	$params = array('symbol' => $symbol, 'username' => $username, 'portfolio_name'=>$portfolio_name, 'requested_num_of_shares'=>$requested_num_of_shares, 'cost'=>$cost, 'total_cost'=>$total_cost);
	$url = $endpoint . '?' . http_build_query($params);
	curl_setopt($curl, CURLOPT_URL, $url);
	$response = curl_exec($curl);
    curl_close($curl);
	//print_r($response) . "<br>";
	//return json_encode($response);
	//echo json_encode($url);
$share_check = "SELECT shares FROM performance WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol = '$symbol'";
$result = $conn-> query($share_check);
while ($row = $result -> fetch_assoc()){
    if ($row['shares'] == 0){
        $conn->query("DELETE FROM overview WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol = '$symbol'");
        $conn->query("DELETE FROM performance WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol = '$symbol'");
    }
}
//}




/*


$cash_query = "SELECT * FROM cash WHERE username = '$username' and portfolio_name = '$portfolio_name'";
withdraw_from_cash($conn, $cash_query, $total_cost, $username, $portfolio_name);

$transaction_query = "INSERT INTO transaction (portfolio_name, username, company_name, symbol, type, timestamp, shares, price, amount) VALUES('$portfolio_name','$username','$company_name', '$symbol', 'Buy', NOW(), '$num_of_shares', '$total_cost', NULL)";
insert_stock_data_into_txn_table($conn, $transaction_query);

$checkPerfSQL = "SELECT * FROM performance WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol = '$symbol' ";
$performance_query = "INSERT INTO performance (username, portfolio_name, symbol, company_name, buy_price, buy_date, shares, current_price, currency, gain_loss, port_nav) VALUES('$username', '$portfolio_name', '$symbol', '$company_name', '$cost', NOW(), '$num_of_shares', '$current_price', '$currency', NULL, NULL)";
insert_stock_data_into_performance_table($conn, $checkPerfSQL, $performance_query, $total_cost, $num_of_shares, $username, $portfolio_name, $symbol);


$overview_query = "SELECT * FROM overview WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol = '$symbol' ";
insert_stock_data_into_overview_table($conn, $overview_query, $username, $portfolio_name, $symbol, $arr);



*/
