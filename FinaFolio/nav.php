<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Layout/ind.css">

    <style>
        body{
            margin:0;
        }

        .topnav{
            overflow:hidden;
            background-color:ghostwhite;
            top:0;
        }
        .topnav input{
            display: inline-block;
            font-size:17px;
            border-radius: 8px;
        }

    </style>

    <div class="topnav">
        <span class="fina">FinaFolio: </span> &emsp; America's #1 Portfolio Manager

        <div style=" padding: 2px; display: inline-block; margin-left: 5%; width: 35%">
            <input  class="bySel" type="button" value="Upload Order" onclick="oMenu()" id="oBtn">
            <input  class="bySel" type="button" value="Buy Stock" onclick="bMenu()" id="bBtn" style="margin-left: 7%"> &emsp;
            <input class="bySel" type="button" value="Sell Stock" onclick="sMenu()" id="sBtn" style="margin-left: 7%">
        </div>

        <div class="bsMenu" id="orderM" hidden>
            <b style="display: inline-block; margin: 7px">Upload Order File:</b>
            <br>
            <span style="margin-left: 20%; position: relative;display: inline-block;">
                <label for="uploadFile" style="font-size: small; ">&emsp; Upload File: </label>
                <input type="file" id="uploadFile" style="margin: 15px 7px" onchange="orderChk()">
                <span class="tab" id="removeF" onclick="clearFile()" style="display: none">Remove</span>
            </span>
            <input style=" display: inline" type="button" value="Submit Order" class="bySel" id="oButton" onclick="order()" disabled> &emsp;
            <span style="color: limegreen" id="oStatus"></span>
            <!--<form action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="file" id="uploadFile" style="margin: 15px 7px" onchange="orderChk()">
                    <span class="tab" id="removeF" onclick="clearFile()" style="display: none">Remove</span>
                    <input style=" display: inline" type="submit" value="Submit Order" class="bySel" id="oButton" onclick="order()" disabled> &emsp;
                    <span style="color: limegreen" id="oStatus"></span>
                </form>-->
        </div>

        <div class="bsMenu" id="buyM" hidden>
            <b style="display: inline-block; margin: 7px">Buy Stock:</b>
            <br>
            <span style="margin-left: 3%; position: relative;display: inline-block;">
                <label for="searchTic" style="font-size: small; ">&emsp; Select Ticker: </label>
                <input type="text" id="searchTic" style="margin: 15px 7px" placeholder="  Enter Ticker" onkeyup="filterMrkt()">
                <table id="dropdownB" class="dropdown-content" hidden></table>
            </span>
            <span style="margin-left: 5%">
                <label for="amtB" style="font-size: small">Number (of Shares):</label>
                <input type="number" id="amtB" oninput="calcPrice('buy')" min="1" disabled>
            </span>
            <span style="margin-left: 5%" class="tooltip">
                <label for="bPrice" style="font-size: small">Total Price =  $</label>
                <span id="bPrice">0</span>
            </span>
            <input style="margin-left: 45%" type="button" value="Buy Now" class="bySel" id="bButton" onclick="buy()" disabled> &emsp;
            <span style="color: limegreen" id="bStatus"></span>
        </div>
        <div class="bsMenu" id="sellM" hidden>
            <b style="display: inline-block; margin: 7px">Sell Stock:</b>
            <br>
            <span style="margin-left: 3%; position: relative;display: inline-block;">
                <label for="searchPort" style="font-size: small; ">&emsp; Select Ticker: </label>
                <input type="text" id="searchPort" style="margin: 15px 7px" placeholder="  Enter Ticker" onkeyup="filterStock()" onclick="filterStock()">
                <table id="dropdownS" class="dropdown-content" hidden></table>
            </span>
            <span style="margin-left: 5%">
                <label for="amtS" style="font-size: small">Number (of Shares):</label>
                <input type="number" id="amtS" oninput="calcPrice('sell')" min="1" disabled>
            </span>
            <span style="margin-left: 5%" class="tooltip">
                <label for="sPrice" style="font-size: small">Total Value =  $</label>
                <span id="sPrice">0</span> &emsp;
                <span class="tooltext"></span>
            </span>
            <input style="margin-left: 45%" type="button" value="Sell Now" class="bySel" id="sButton" onclick="sell()" disabled> &emsp;
            <span style="color: limegreen" id="sStatus"></span>
        </div>

        <span class="name" id="name"></span>
        <input type="button" class="button" value="Logout" onclick="logOut();" style="float: right; margin-right: 1%; margin-top: 1.5%">
    </div>

    <script>

        var name = '<?php echo $_SESSION['name'] ?>'.toUpperCase();
        var userid = '<?php echo $_SESSION['username'] ?>';

        $(document).ready(function(){
            $("#name").html(name);
        });

        function close() {
            $(document).mouseup(function (e) {
                var oM = $('#orderM');
                var bM = $('#buyM');
                var sM = $('#sellM');
                var oBtn = $('#oBtn');
                var bBtn = $('#bBtn');
                var sBtn = $('#sBtn');

                // if the target of the click isn't the container nor a descendant of the container
                if ((!oM.is(e.target) && oM.has(e.target).length === 0) && (!oBtn.is(e.target) && oBtn.has(e.target).length === 0)) {
                    oM.prop("hidden",true);
                    reset();
                }
                if ((!bM.is(e.target) && bM.has(e.target).length === 0) && (!bBtn.is(e.target) && bBtn.has(e.target).length === 0)) {
                    bM.prop("hidden",true);
                    reset();
                }
                if ((!sM.is(e.target) && sM.has(e.target).length === 0) && (!sBtn.is(e.target) && sBtn.has(e.target).length === 0)) {
                    sM.prop("hidden",true);
                    reset();
                }

            });
        }

        function logOut() {
            localStorage.clear();
            location.href="logout.php";
        }

        function orderChk(){

            if ($('#uploadFile').val()=== "" || $('#uploadFile').val()=== null) {
                $('#oButton').prop('disabled', true);
                $('#removeF').css('display', 'none');
            } else {
                $('#oButton').prop('disabled', false);
                $('#removeF').css('display', '');
            }
        }

        function clearFile(){
            $('#uploadFile').val('');
            orderChk();
        }
        function filterMrkt(){

            if (document.getElementById('dropdownB').hasAttribute("hidden") === true){
                $('#dropdownB').prop("hidden",false);
            }
            var input, filter, tr, i, table, txtValue;
            input = document.getElementById("searchTic");
            filter = input.value.toUpperCase();
            table = document.getElementById("dropdownB");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                txtValue = tr[i].textContent || tr[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                    $('#amtB').prop('disabled', true);
                    $('#bButton').prop('disabled', true);
                }
            }
        }
        function inputSymM(id) {

            var tickr = document.getElementById("searchTic");
            var pric = document.getElementById(id);
            let num = pric.childNodes[5].innerText;
            num = num.replace(/,/g, "");

            var amtB =$('#amtB');
            console.log(num);
            cost = num;
            console.log(cost);
            localStorage.setItem("tkrPrice",num);
            tickr.value = id;
            $('#dropdownB').prop("hidden",true);
            amtB.prop('disabled',false);
            $('#bButton').prop('disabled',false);
            amtB.val(1);
            calcPrice('buy');
        }
        function inputStkSymM(id,max) {

            var tickr = document.getElementById("searchPort");
            var pric = document.getElementById(id);
            let numS = pric.childNodes[5].innerText;
            numS = numS.replace(/,/g, "");

            var amtS =$('#amtS');

            amtS.prop('max',max);
            console.log(numS);
            cost = numS;
            console.log(cost);
            localStorage.setItem("stkPrice",numS);
            tickr.value = id;
            $('#dropdownS').prop("hidden",true);
            amtS.prop('disabled',false);
            $('#sButton').prop('disabled',false);
            amtS.val(1);
            calcPrice('sell');
        }
        function calcPrice(type) {

            if(type==='buy') {
                var bPrice = $('#bPrice');
                var amtB = $('#amtB');

                if (amtB.val() !== "" && amtB.val() !== null && amtB.val() > 0) {
                    var num = parseInt(amtB.val());
                    console.log(num);
                    var initP = localStorage.getItem("tkrPrice");
                    var totPrice = num * parseFloat(initP);
                    bPrice.html(totPrice.toFixed(2));
                    $('#bButton').prop('disabled', false);
                } else {
                    bPrice.html(0);
                    $('#bButton').prop('disabled', true);
                }
            } else if(type==='sell'){
                var sPrice = $('#sPrice');
                var amtS = $('#amtS');
                var tooltext = $('.tooltext');

                if (amtS.val() !== "" && amtS.val() !== null && amtS.val() > 0 && parseInt(amtS.val()) <= amtS.prop('max')) {
                    var numS = parseInt(amtS.val());
                    console.log(numS);
                    var initV = localStorage.getItem("stkPrice");
                    var totVal = numS * parseFloat(initV);
                    sPrice.html(totVal.toFixed(2));
                    $('#sButton').prop('disabled', false);
                    tooltext.html('');
                } else {
                    sPrice.html(0);
                    $('#sButton').prop('disabled', true);
                    tooltext.html('');
                }
                if(parseInt(amtS.val()) > amtS.prop('max')){
                    tooltext.html('(Number exceeds available amount of shares)');
                }
            }
        }

    </script>

</head>