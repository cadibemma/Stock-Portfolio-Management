<?php

$servername = "sql1.njit.edu";
$username = "cla22";
$password = "R0zvjMD6z";
$dbname = "cla22";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error ) {
    die("Could not connect to MySQL database: " . $conn->connect_error);
}

function getChange($symbol) {

    $ch = curl_init('https://finance.yahoo.com/quote/'.$symbol.'/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    $content = curl_exec($ch);
    //echo htmlspecialchars($content);
    curl_close($ch);

    /*** a new dom object ***/ 
    $dom = new domDocument; 
   
    /*** load the html into the object ***/
    $dom->loadHTML($content); 

    $classnameGain = "Trsdu(0.3s) Fw(500) Pstart(10px) Fz(24px) C(\$dataGreen)"; // GAIN
    $classnameLoss = "Trsdu(0.3s) Fw(500) Pstart(10px) Fz(24px) C(\$dataRed)"; // LOSS
    $classnameZero = "Trsdu(0.3s) Fw(500) Pstart(10px) Fz(24px)"; // 0.00 (0.00%)
    //echo 'classname: '.$classname.'<br>';
    echo 'symbol: '.$symbol.'<br>';
    $finder = new DomXPath($dom);
    //$change = "";
    
    if ($finder->query("//*[contains(@class, '$classnameGain')]")->length != 0) {
        $spaner = $finder->query("//*[contains(@class, '$classnameGain')]");
        //print_r($spaner);
        $change = $spaner->item(0)->nodeValue;
    } else if ($finder->query("//*[contains(@class, '$classnameLoss')]")->length != 0) {
        $spaner = $finder->query("//*[contains(@class, '$classnameLoss')]");
        $change = $spaner->item(0)->nodeValue;
    } else {
        $spaner = $finder->query("//*[contains(@class, '$classnameZero')]");
        $change = $spaner->item(0)->nodeValue;
    }
    
    echo 'change: '.$change.'<br>';
    if ($change == null) {
        echo 'change is null oo'.'<br>';
    }
    if ($change == '') {
        echo 'change is empty oo'.'<br>';
    }
    return $change;
}

function getPrice($symbol) {

    $ch = curl_init('https://finance.yahoo.com/quote/'.$symbol.'/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    $content = curl_exec($ch);
    //echo htmlspecialchars($content);
    curl_close($ch);

    /*** a new dom object ***/ 
    $dom = new domDocument; 
   
    /*** load the html into the object ***/
    $dom->loadHTML($content); 

    $classname="Trsdu(0.3s) Fw(b) Fz(36px) Mb(-4px) D(ib)";
    //echo 'classname: '.$classname.'<br>';
    $finder = new DomXPath($dom);
    $spaner = $finder->query("//*[contains(@class, '$classname')]");
 
    //echo $spaner->item(0)->nodeValue.'<br>';
    return $spaner->item(0)->nodeValue;
}

function endsWith($string, $endString) { 
    $len = strlen($endString); 
    if ($len == 0) { 
        return true; 
    } 
    return (substr($string, -$len) === $endString); 
}

function removeComma($number){
    $b = str_replace( ',', '', $number );
    return $b;
}

function getExchangeRate($convertFrom, $convertTo) {

    $ch = curl_init('https://finance.yahoo.com/quote/'.$convertFrom.$convertTo.'=X/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    $content = curl_exec($ch);
    //echo htmlspecialchars($content);
    curl_close($ch);

    /*** a new dom object ***/ 
    $dom = new domDocument; 
   
    /*** load the html into the object ***/
    $dom->loadHTML($content); 

    $classname="Trsdu(0.3s) Fw(b) Fz(36px) Mb(-4px) D(ib)";
    $finder = new DomXPath($dom);
    $spaner = $finder->query("//*[contains(@class, '$classname')]");
 
    //echo $spaner->item(0)->nodeValue.'<br>';
    return $spaner->item(0)->nodeValue;
}

function getPriceInUSD($rate, $price) {

    //echo "received price is >> ".$price.'<br>';

    if ($price == NULL) {
        $price = 0;
    }
    $a = $price;
    $b = str_replace( ',', '', $a );

    //echo "received price is >> ".$b.'<br>';
    return round(($rate * $b), 2);

}

function updateMarketTable($conn, $symbol, $checkMarketSQL, $current_price, $usd_price, $change, $percent_change, $volume) {
    $result = $conn->query($checkMarketSQL);
    if ($result->num_rows > 0) {
        //echo  "FOUND SOMETHING IN TABLE". "<br>";

//market
//symbol, company_name, exchange, 9_2_price, currency, current_price, usd_price, change, %change, volume
// current_price, usd_price, change, %change, volume
        $sql = "UPDATE market SET current_price='$current_price', usd_price='$usd_price', `change`='$change', `%change`='$percent_change', volume='$volume' WHERE symbol = '$symbol' ";
        if ($conn->query($sql) === TRUE) {
            //echo  "update completed successfully". "<br>";
        } else {
            die ("Could not perform update: " . $conn->error);
        }
    } else {
            die ("Symbol not found in database: " . $conn->error);
        }
     
}

// future enhancement - user must die() in the else if we determine that a nonexistent username or portfolio_name was submitted
// but a wrong username or portfolio_name will never be submitted as this is a backend call from the UI
function getCurrentSymbols($conn, $username, $portfolio_name) {
    $sql = "SELECT DISTINCT symbol FROM transaction WHERE username = '$username' and portfolio_name = '$portfolio_name'";
    $result = $conn->query($sql);
    $currentSymbols = array();

    if ($result->num_rows > 0) {
        //echo "FOUND SOME STOCKS".'<br>';
        while($row = $result->fetch_assoc()) {
            array_push($currentSymbols, $row["symbol"]);
        }
    } else {
        //echo "NO STOCKS".'<br>';
    }

    return $currentSymbols;

}

function getDataFromMarketTable($conn, $currentSymbols) {
    $sgd_to_usd_rate = getExchangeRate('SGD', 'USD');
    $inr_to_usd_rate = getExchangeRate('INR', 'USD');
    $symbols_arr = array();
    $symbols_arr["records"] = array();

    $sql = "SELECT symbol, company_name, 9_2_price, usd_price FROM market";
    $result = $conn->query($sql);

    if (empty($currentSymbols)) {
        while ($row = $result->fetch_assoc()) {
            $price = get_usd_price_from_9_2_price($sgd_to_usd_rate, $inr_to_usd_rate, $row["symbol"], $row["9_2_price"]);

            $symbol_item=array(
                "symbol" => $row["symbol"],
                "company_name" => $row["company_name"],
                "current_price" => $price
            );
            array_push($symbols_arr["records"], $symbol_item);
        }
    } else {
        while ($row = $result->fetch_assoc()) {
            $currentSymbol = $row["symbol"];
            if (in_array($currentSymbol, $currentSymbols)) {
                //get current_price - not first time buyer
                $price = $row["usd_price"];

                $symbol_item=array(
                    "symbol" => $currentSymbol,
                    "company_name" => $row["company_name"],
                    "current_price" => $price
                );
                array_push($symbols_arr["records"], $symbol_item);

            } else {
                //get 9_2_price - is first time buyer
                $price = get_usd_price_from_9_2_price($sgd_to_usd_rate, $inr_to_usd_rate, $currentSymbol, $row["9_2_price"]);

                $symbol_item=array(
                    "symbol" => $currentSymbol,
                    "company_name" => $row["company_name"],
                    "current_price" => $price
                );
                array_push($symbols_arr["records"], $symbol_item);

            }
        }
        
    }

    http_response_code(200);

    // show stock data in json format
    echo json_encode($symbols_arr, JSON_PRETTY_PRINT);

}

function getCurrentSymbolandShare($conn, $username, $portfolio_name) {
    $sql = "SELECT symbol,shares FROM performance WHERE username = '$username' and portfolio_name = '$portfolio_name'";
    $result = $conn->query($sql);
    $currentSymShare = array();

    if ($result->num_rows > 0) {
        //echo "FOUND SOME STOCKS".'<br>';
        while($row = $result->fetch_assoc()) {

            $symbol_data=array(
                "symbol" => $row["symbol"],
                "shares" => $row["shares"]
            );

            array_push($currentSymShare, $symbol_data);
        }
    } else {
        //echo "NO STOCKS".'<br>';
    }

    return $currentSymShare;

}

function get_number_of_shares($conn, $sql) {
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        //echo "FOUND SOME SHARES".'<br>';
        while($row = $result->fetch_assoc()) {
            $current_num_of_shares = $row["shares"];
        }
    } else {
        //echo "NO SHARES".'<br>';
    }
    return $current_num_of_shares;

}

function get_usd_price_from_9_2_price($sgd_to_usd_rate, $inr_to_usd_rate, $symbol, $price) {
    $usd_price = "";
    if (endsWith($symbol, '.SI')) {
        $usd_price = getPriceInUSD($sgd_to_usd_rate, $price);
    } else if (endsWith($symbol, '.BO') || endsWith($symbol, '.NS')) {
        $usd_price = getPriceInUSD($inr_to_usd_rate, $price);
    } else {
        $usd_price = $price;
    }

    return $usd_price;
}

function getSymbolDataFromMarketTable($conn, $symbol) {
    //$sgd_to_usd_rate = getExchangeRate('SGD', 'USD');
    //$inr_to_usd_rate = getExchangeRate('INR', 'USD');
    $symbol_info = array();

    $sql = "SELECT * FROM market WHERE symbol = '$symbol'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

            $symbol_info=array(
                "symbol" => $row["symbol"],
                "company_name" => $row["company_name"],
                "9_2_price" => $row["9_2_price"],
                "currency" => $row["currency"],
                "current_price" => $row["current_price"],
                "usd_price" => $row["usd_price"],
                "change" => $row["change"],
                "percent_change" => $row["%change"],
                "volume" => $row["volume"]
            );
    }

    return $symbol_info;
}

function withdraw_from_cash($conn, $cash_query, $total_cost, $username, $portfolio_name) {
    $result = $conn->query($cash_query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $available_funds = $row["amount"];

        if (min($total_cost, $available_funds) === $total_cost) {
            $updated_available_funds = $available_funds - $total_cost;
            $sql = "UPDATE cash SET amount='$updated_available_funds' WHERE username = '$username' and portfolio_name = '$portfolio_name'";
            if ($conn->query($sql) === TRUE) {
                echo "update completed successfully";
            } else {

                //set response code - 503 service unavailable
                http_response_code(503);
                //echo json_encode(array("message" => $conn->error));
                die("Could not perform withdrawal: " . $conn->error);
            }

        } else {

            http_response_code(400);
            //echo "Insufficient funds. Amount requested is greater than available balance.";
            die("Insufficient funds - Amount requested greater than available amount");
        }

    } else {

        http_response_code(400);
        //echo "Insufficient funds - $0.00 in account.";
        die("insufficient funds - $0.00 in account");
    }

}


function insert_stock_data_into_txn_table($conn, $transaction_query) {
    if ($conn->query($transaction_query) === TRUE) {
        //echo "Entered data successfully";
        http_response_code(200);
        //echo json_encode(array("message" => "success for txn."));
    } else {
        http_response_code(503);
        //echo json_encode(array("message" => $conn->error));
        die("Could not enter data: " . $conn->error);
    }
}


function insert_stock_data_into_performance_table($conn, $checkPerfSQL, $performance_query, $cost, $num_of_shares, $username, $portfolio_name, $symbol) {
    $result = $conn->query($checkPerfSQL);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $shares_in_db = $row["shares"];
        $final = $shares_in_db + $num_of_shares;

        $sql = "UPDATE performance SET buy_price='$cost', buy_date=NOW(), shares='$final' WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol='$symbol'";
        if ($conn->query($sql) === TRUE) {
            //echo "update completed successfully";

        } else {
            http_response_code(503);
            //echo json_encode(array("message" => $conn->error));
            die("Could not add performance data: " . $conn->error);
        }

    } else {
        if ($conn->query($performance_query) === TRUE) {
            //echo "added performance data successfully";

        } else {
            http_response_code(503);
            //echo json_encode(array("message" => $conn->error));
            die("Could not add performance data: " . $conn->error);
        }
    }
}




function insert_stock_data_into_overview_table($conn, $overview_query, $username, $portfolio_name, $symbol, $arr) {
    $result = $conn->query($overview_query);
    //$stockInfo = array();

    //$arr = getSymbolDataFromMarketTable($conn, $symbol);

    $company_name = addslashes($arr["company_name"]);
    $currency = $arr["currency"];
    $cost = $arr["usd_price"];
    $last_price = $arr["current_price"];
    $change = $arr["change"];
    $percent_change = $arr["percent_change"];
    $volume = $arr["volume"];

    //$stockInfo = fetchMarket($symbol);
    //print_r($stockInfo);
    //$company_name = addslashes($stockInfo[1]);
    //$last_price = round($stockInfo[2], 2);
    //$change = round($stockInfo[3], 2);
    //$percent_change = round($stockInfo[4], 2);
    //$volume = removeComma($stockInfo[5]);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $sql = "UPDATE overview SET lastprice='$last_price', `change` ='$change', `%change` ='$percent_change', volume='$volume' WHERE username = '$username' and portfolio_name = '$portfolio_name' and symbol = '$symbol'";
        if ($conn->query($sql) === TRUE) {
            //echo  "update completed successfully";
            http_response_code(200);
            //echo json_encode(array("message" => "success @ overview"));
        } else {
            http_response_code(503);
            //echo json_encode(array("message" => $conn->error));
            die ("Could not perform overview: " . $conn->error);
        }


    } else {
        $sql = "INSERT INTO overview (username, portfolio_name,symbol, company_name,lastprice, `change`, `%change`, volume) VALUES ('$username', '$portfolio_name', '$symbol', '$company_name', '$last_price', '$change', '$percent_change', '$volume')";
        if ($conn->query($sql) === TRUE) {
            //echo "added overview data successfully";
            http_response_code(200);
            //echo json_encode(array("message" => "success at overview"));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => $conn->error));
            die ("Could not add overview data: " . $conn->error);
        }
    }
}

// used for overview
// returns an array with all symbols
function getSymbolsForUser($conn, $sql) {
    $result = $conn->query($sql);
    $symbols = array();
    if ($result->num_rows > 0) {
        //echo "FOUND OVERVIEW DATA FOR USER";
        while($row = $result->fetch_assoc()) {
            array_push($symbols, $row["symbol"]);
        }
        //print_r($symbols);
        return $symbols;

    } else {
        //echo "OVERVIEW DATA NOT FOUND";
        die();
    }
}


//MMDDYY HH:MM:SS - UTC => 001700
//in - ticker, exchange, date
//out - ticker, exchange, date, price, currency, exchange-rate


//Java app - test client server, use any port > 1024

// processbuilder in Java 8 for R component
// get R script working






