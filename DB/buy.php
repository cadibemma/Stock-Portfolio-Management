<?php

include 'functions.php';

// 1. Check cash table to determine if user has enough funds to purchase stock[available cash >= total_cost]
// 2. If [available cash >= total_cost], withdraw cash and update cash table, return success message - withdraw_from_cash()
// 3. Insert data into transaction table with withdrawal/transaction details - insert_stock_data_into_txn_table()
// 4. Insert data into performance table - insert_stock_data_into_performance_table()
// 5. Insert data into overview table - insert_stock_data_into_overview_table()
// 6. If [available cash < total_cost], return insufficient funds message

//header('Content-Type: application/json');

$symbol = isset($_GET['ticker']) ? $_GET['ticker'] : die();
//$company_name = isset($_GET['company_name']) ? $_GET['company_name'] : die();
$username = isset($_GET['username']) ? $_GET['username'] : die();
$portfolio_name = isset($_GET['portfolioname']) ? $_GET['portfolioname'] : die();
$num_of_shares = isset($_GET['num_of_shares']) ? $_GET['num_of_shares'] : die();
$cost = isset($_GET['cost']) ? $_GET['cost'] : die();
$total_cost = isset($_GET['total_cost']) ? $_GET['total_cost'] : die();

$arr = getSymbolDataFromMarketTable($conn, $symbol);
$company_name = addslashes($arr["company_name"]);
$currency = $arr["currency"];
//$cost = $arr["usd_price"];
$current_price = $arr["current_price"];


$cash_query = "SELECT * FROM cash WHERE username = '$username' and portfolio_name = '$portfolio_name'";
withdraw_from_cash($conn, $cash_query, $total_cost, $username, $portfolio_name);

$transaction_query = "INSERT INTO transaction (portfolio_name, username, company_name, symbol, type, timestamp, shares, price, amount) VALUES('$portfolio_name','$username','$company_name', '$symbol', 'Buy', NOW(), '$num_of_shares', '$total_cost', NULL)";
insert_stock_data_into_txn_table($conn, $transaction_query);

$checkPerfSQL = "SELECT * FROM performance WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol = '$symbol' ";
$performance_query = "INSERT INTO performance (username, portfolio_name, symbol, company_name, buy_price, buy_date, shares, current_price, currency, gain_loss, port_nav) VALUES('$username', '$portfolio_name', '$symbol', '$company_name', '$cost', NOW(), '$num_of_shares', '$current_price', '$currency', NULL, NULL)";
insert_stock_data_into_performance_table($conn, $checkPerfSQL, $performance_query, $cost, $num_of_shares, $username, $portfolio_name, $symbol);


$overview_query = "SELECT * FROM overview WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol = '$symbol' ";
insert_stock_data_into_overview_table($conn, $overview_query, $username, $portfolio_name, $symbol, $arr);

