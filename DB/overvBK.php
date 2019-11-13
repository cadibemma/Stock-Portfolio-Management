<?php

include 'functions.php';

$username = $_POST['username'];
$portfolio_name = $_POST['portfolioname'];

// username, portfolio_name, symbol, company_name, buy_price, buy_date, shares, current_price, currency, gain_loss, port_nav
$sql = "SELECT * FROM overview WHERE username = '$username' and portfolio_name = '$portfolio_name'";

$symbolsArray = getSymbolsForUser($conn, $sql);
$symbols_arr = array();
$symbols_arr["overview"] = array();

foreach ($symbolsArray as $symbol) {
    array_push($symbols_arr["overview"], getSymbolDataFromMarketTable($conn, $symbol));
}

//print_r($symbols_arr);
echo json_encode($symbols_arr);


