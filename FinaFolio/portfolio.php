<html lang="en">

<span style="display: inline-block; float: left; font-size: large; padding: 15px;" id="pName"></span>
<input type="button" value="Create New Portfolio" style="float: right; font-size: 14px; border-radius: 8px; margin-top: 15px; padding: 5px; cursor: pointer" onclick="addFolio();">
<br><br><br><br>
<div id="allData" hidden>
    <div>
        <a class="tab" style="border-right: 3px solid black; color: black" id="overv" onclick="tView(this.id)">Overview</a>
        <a class="tab" style="border-right: 3px solid black;" id="perform" onclick="tView(this.id)">Performance</a>
        <a class="tab" id="transac" onclick="tView(this.id)">Transactions</a>
    </div>
    <br>
    <div style=" overflow: auto;background-color: azure; padding: 2px">
    <span id="secOptions" style="float: right;">

        <a class="subTab" style="border-right: 1px solid black;" id="modifyP">Modify portfolio</a>
        <a class="subTab" style="border-right: 1px solid black;" id="deleteP">Delete portfolio</a>
        <a class="subTab" id="dloadCSV">Download as CSV</a>
    </span>
    </div>
    <div id="tableV" style="display: block"><?php include "PInclude/overview.php" ?></div>
    <form id="formCSV" action="../DB/dnldCSV.php" method="post" hidden>
        <input type="text" id="username" name="username" >
        <input type="text" id="portfolioname" name="portfolioname" >
    </form>
    <div class="footer" style="border: turquoise 2px solid;">
        <div class="cash">
            Cash -
            <a onclick="deposit()">Deposit</a> / <a onclick="withdraw()">Withdraw</a>
        </div>
        <div style="background-color: lightsteelblue; overflow: auto; text-align: center; padding: 15px; border: turquoise 2px solid;">
            <b>Cash Balance: &emsp;<span id="balance"></span></b>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        mrktBuy();
        stkList();
    });
    function oMenu() {
        //if menu hidden, then show and run post. else visibility is hidden
        if(document.getElementById('orderM').hasAttribute("hidden") === true){
            $('#sellM').prop("hidden",true);
            $('#buyM').prop("hidden",true);
            $('#orderM').prop("hidden",false);

            close();

        } else {
            $('#orderM').prop("hidden",true);
            reset();
        }
    }
    function bMenu() {
        //if menu hidden, then show and run post. else visibility is hidden
        if(document.getElementById('buyM').hasAttribute("hidden") === true){
            $('#sellM').prop("hidden",true);
            $('#buyM').prop("hidden",false);
            $('#orderM').prop("hidden",true);


            close();

        } else {
            $('#buyM').prop("hidden",true);
            reset();
        }
    }
    function sMenu() {
        //if menu hidden, then show and run post. else visibility is hidden
        if(document.getElementById('sellM').hasAttribute("hidden") === true){
            $('#buyM').prop("hidden",true);
            $('#sellM').prop("hidden",false);
            $('#orderM').prop("hidden",true);



            stkList();
            close();

            var portfolio = localStorage.getItem("idPortfolio");

            /*$.post("../DB/sellOpt.php",
                {
                    username: userid ,
                    portfolioname: portfolio,

                },
                function(data, status){
                    console.log(data);
                    console.log(status);

                });*/

        } else {
            $('#sellM').prop("hidden",true);
            reset();
        }
    }
    function deposit() {
        var portfolio = localStorage.getItem("idPortfolio");
        var amoun= prompt("Enter the amount you would like to deposit (Numbers Only):");
        var amount = parseFloat(amoun);
        console.log(amount);

        if (amoun === "") {
            alert("Amount can not be left blank");
        }else if (Number.isNaN(amount) === true || amount < 0){
            alert("This is not a valid amount");
        }else if (amoun !== "" && amoun !== null){
            $.post("../DB/depWithd.php",
                {
                    username: userid ,
                    portfolioname: portfolio,
                    amount: amount,
                    type: "deposit"
                },
                function(data, status) {
                    console.log(data);
                    console.log(status);

                    location.reload();
            });
        }
    }
    function withdraw(){
        var portfolio = localStorage.getItem("idPortfolio");
        var amoun= prompt("Enter the amount you would like to withdraw (Numbers Only):");
        var amount = parseFloat(amoun);
        console.log(amount);

        if (amoun === "") {
            alert("Amount can not be left blank");
        }else if (Number.isNaN(amount) === true || amount < 0){
            alert("This is not a valid amount");
        }else if (amoun !== "" && amoun !== null){
            $.post("../DB/depWithd.php",
                {
                    username: userid ,
                    portfolioname: portfolio,
                    amount: amount,
                    type: "withdraw"
                },
                function(data, status){
                    console.log(data);
                    console.log(status);

                    if (data ===  "REQUESTED AMOUNT EXCEEDS AMOUNT AVAILABLE"){
                        alert(data);
                    }

                    location.reload();
                });
        }

    }
    function getBal() {
        var portfolio = localStorage.getItem("idPortfolio");

        $.post("../DB/cashBal.php",
                {
                    username: userid ,
                    portfolioname: portfolio
                },
                function(data, status){

                    if(data === "" || data === null){
                        $('#balance').html('$0');
                    } else
                        $('#balance').html('$'+ parseFloat(data).toFixed(2));

                });
    }

    $('#modifyP').click(function(){
        var port = localStorage.getItem("idPortfolio");
        var portfolio= prompt("Rename portfolio:");
        let pname = portfolio.toLowerCase().trim();

        pname = pname.replace(/\s/g,"_");

        if (portfolio === "") {
            alert("Name can not be left blank");
        }else if (portfolio !== "" && portfolio !== null){
            $.post("../DB/create_port.php",
                {
                    username: userid ,
                    portfolioname: port,
                    newname: pname,
                    type: 'rename'

                },
                function(data, status){
                    console.log(data);
                    console.log(status);

                    localStorage.setItem("idPortfolio", "");


                    location.reload();
                });
        }
    });

    $('#deleteP').click(function(){
        var removeP = confirm("Are you sure you want to delete this portfolio?\n\nWARNING: All data will be lost " +
            "(Cash/Stock/etc). Please remember to sell ALL stock and withdraw ALL cash before doing so.");
        if (removeP) {
            var portfolio = localStorage.getItem("idPortfolio");

            $.post("../DB/deletePort.php",
                {
                    username: userid,
                    portfolioname: portfolio
                },
                function (data, status) {
                    console.log(data);
                    console.log(status);
                    localStorage.setItem("idPortfolio", "");
                    location.reload();
                });
        }
    });

    $('#dloadCSV').click(function(e){
        var portfolio = localStorage.getItem("idPortfolio");

        e.preventDefault();
        $("#username").val(userid);
        $("#portfolioname").val(portfolio);

        $("#formCSV").submit();
    });
</script>
</html>