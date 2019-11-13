<?php

include 'functions.php';

// query performance table with username and portfolio_name.
// get all symbols from table - store in array() called currentSymbols[]
// query market table with symbol names not in currentSymbols[]
// get all symbol info and store in json - send json response;
// hurray!

//header('Content-Type: application/json');

/*$username = $_POST['username'];
$portfolio_name = $_POST['portfolioname'];*/

$username = isset($_GET['username']) ? $_GET['username'] : die();
$portfolio_name = isset($_GET['portfolioname']) ? $_GET['portfolioname'] : die();

$currentSymbols = getCurrentSymbols($conn, $username, $portfolio_name);
//print_r($currentSymbols);

// loop through $currentSymbols and create JSON
getDataFromMarketTable($conn, $currentSymbols);
