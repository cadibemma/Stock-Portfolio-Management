<?php

include 'functions.php';

// query performance table with username and portfolioname.
// get all symbols from table - store in array() called currentSymbols[]
// foreach symbol, get company_name and current_price from market table - send json response;
// return array with objects {"stocks":[{symbol, company_name, current_price}]}
// hurray!

//header('Content-Type: application/json');

$username = isset($_GET['username']) ? $_GET['username'] : die();
$portfolio_name = isset($_GET['portfolioname']) ? $_GET['portfolioname'] : die();
$currentSymShare = getCurrentSymbolandShare($conn, $username, $portfolio_name);

//print_r($currentSymbols);
$symbols_arr = array();
$symbols_arr["stocks"] = array();
$list = array();

foreach ($currentSymShare as $symbol) {

    //array_push($shares['shares'], $symbol['shares']);
    $list =array(
        'shares' => $symbol['shares'],
        getSymbolDataFromMarketTable($conn, $symbol['symbol'])
    );
    array_push($symbols_arr["stocks"], $list);
}

//print_r($symbols_arr);
echo json_encode($symbols_arr);