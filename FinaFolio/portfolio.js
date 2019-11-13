var cost;

$(document).ready(function(){
    var idP = localStorage.getItem("idPortfolio");
    var allData = $('#allData');
    allData.prop('hidden',false);
    if (idP !== null && idP !== "")
    {
        let str = idP;
        str = str.replace(/_/g, " ");

        $('#pName').html(str.toUpperCase());
        getBal();
    }
    else{
        allData.html('<div class="noFolio">' +
            '<b><em>Please select a Portfolio to view. ' +
            '<br>If none available, click on  "Create New Portfolio"</em></b>' +
            '</div>');
        $('#bBtn').prop("disabled",true).attr("class",'').attr('style','font-size: 16px; border-radius: 8px;');
        $('#sBtn').prop("disabled",true).attr("class",'').attr('style','font-size: 16px; border-radius: 8px;');
        $('#oBtn').prop("disabled",true).attr("class",'').attr('style','font-size: 16px; border-radius: 8px;');
    }
});

function pLoad(id) {
    localStorage.setItem('idPortfolio', id);
    window.location.reload();
}
function addFolio() {
    var portfolio= prompt("Enter the name of your new portfolio:");
    let str = portfolio.toLowerCase().trim();

    str = str.replace(/\s/g,"_");

    if (portfolio === "") {
        alert("Name can not be left blank");
    }else if (portfolio !== "" && portfolio !== null){
        $.post("../DB/create_port.php",
            {
                username: userid ,
                portfolioname: str,
                type: 'create'
            },
            function(data, status){
                console.log(data);
                console.log(status);

                location.reload();
            });
    }
}
function buy() {

    var portfolio = localStorage.getItem("idPortfolio");
    var ticker = document.getElementById("searchTic").value;
    var numShare = document.getElementById("amtB").value;
    var bStatus = $('#bStatus');
    var bPrice = document.getElementById("bPrice").innerText;
    var totalP = parseFloat(bPrice);
    console.log(totalP);

    $.ajax({
        url: "../DB/buy.php",
        type: "get", //send it through get method
        data: {
            ajaxid: 4,
            username: userid ,
            portfolioname: portfolio,
            ticker: ticker,
            num_of_shares: numShare,
            cost: cost,
            total_cost: totalP
        },
        success: function(response) {
            console.log(response);

            if(response !== "update completed successfully"){
                alert(response.toUpperCase());

                localStorage.setItem("tkrPrice","");
                location.reload();
            }else{
                $('#searchTic').prop('disabled',true);
                $('#amtB').prop('disabled',true);
                $('#bButton').prop('disabled',true).attr("class",'');
                bStatus.html('Success!');
                setTimeout(location.reload.bind(location), 1000);
            }
        },
        error: function(xhr) {
            console.log('THERES AN ERROR');
            //var error = JSON.parse(xhr);
            console.log(xhr);
            alert(xhr.responseText.toUpperCase());
        }
    });
}
function sell(){

    var portfolio = localStorage.getItem("idPortfolio");
    var ticker = document.getElementById("searchPort").value;
    var numShare = document.getElementById("amtS").value;
    var sStatus = $('#sStatus');
    var sPrice = document.getElementById("sPrice").innerText;
    var totalP = parseFloat(sPrice);
    console.log(totalP);
    $.ajax({
        url: "../DB/sell.php",
        type: "get", //send it through get method
        data: {
            ajaxid: 4,
            username: userid ,
            portfolioname: portfolio,
            ticker: ticker,
            num_of_shares: numShare,
            cost: cost,
            total_cost: totalP
        },
        success: function(response) {
            //console.log(JSON.parse(response));
            console.log(response);

            if(response !== "update completed successfully"){
                alert(response.toUpperCase());

                localStorage.setItem("stkPrice","");
                location.reload();
            }else{
                $('#searchPort').prop('disabled',true);
                $('#amtS').prop('disabled',true);
                $('#sButton').prop('disabled',true).attr("class",'');
                sStatus.html('Success!');
                setTimeout(location.reload.bind(location), 1000);
            }
        },
        error: function(xhr) {
            console.log('THERES AN ERROR');
            //var error = JSON.parse(xhr);
            console.log(xhr);
            alert(xhr.responseText.toUpperCase());
        }
    });
}
function order(){

    var portfolio = localStorage.getItem("idPortfolio");
    var file = document.getElementById("uploadFile").value;
    var bStatus = $('#oStatus');

    /*$.post("sell.php",
        {
            username: userid ,
            file: file,
            amount: numShare
        },
        function(data, status){
            console.log(data);
            console.log(status);

            });*/
}
function reset(){
    var orderM= document.getElementById('orderM');
    var buyM= document.getElementById('buyM');
    var sellM = document.getElementById('sellM');


     if (orderM.hasAttribute("hidden") === true){
         $('#uploadFile').val('');
         $('#removeF').css('display', 'none');
         $('#oButton').prop('disabled',true);
     }
     if (buyM.hasAttribute("hidden") === true){
         $('#dropdownB').prop("hidden",true);
         $('#searchTic').val('');
         $('#amtB').val('');
         $('#bPrice').html(0);
         $('#bButton').prop('disabled',true);
     }
     if (sellM.hasAttribute("hidden") === true){
         $('#dropdownS').prop("hidden",true);
         $('#searchPort').val('');
         $('#amtS').val('').prop('disabled',true);
         $('#sPrice').html(0);
         $('#sButton').prop('disabled',true);
     }
}
function filterStock() {
    if (document.getElementById('dropdownS').hasAttribute("hidden") === true){
        $('#dropdownS').prop("hidden",false);
    }
    var input, filter, tr, i, table, txtValue;
    input = document.getElementById("searchPort");
    filter = input.value.toUpperCase();
    table = document.getElementById("dropdownS");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        txtValue = tr[i].textContent || tr[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
            $('#amtS').prop('disabled', true);
            $('#sButton').prop('disabled', true);
        }
    }
}

function stkList() {
    var psList = "";
    var portfolio = localStorage.getItem("idPortfolio");

    $.ajax({
        url: "../DB/ownedStkList.php",
        type: "get", //send it through get method
        data: {
            ajaxid: 4,
            username: userid ,
            portfolioname: portfolio,
        },
        success: function(response) {
            let dataP = JSON.parse(response);

            console.log(dataP.stocks);
            console.log(dataP);

            for (var i = 0; i < dataP.stocks.length; i++) {

                list = `<tr id="${dataP.stocks[i][0].symbol}" onclick="inputStkSymM(this.id,${dataP.stocks[i].shares})" >
                         <td>${dataP.stocks[i][0].symbol}</td>
                         <td class="stklist">${dataP.stocks[i][0].company_name}</td>
                         <td class="stklist" style="color:lightseagreen">${parseFloat(dataP.stocks[i][0].usd_price).toFixed(2)}</td>
                        </tr>`;
                psList += list;
            }
            $('#dropdownS').html(psList);

            $("td.stklist").each(function(){
                if($(this).html() === 'INACTIVE') $(this.parentNode).attr("onclick",'').hover(function () {
                    $(this).css('background-color', 'crimson')}, function () {
                    $(this).css('background-color', 'ghostwhite')});

            })
        },
        error: function(xhr) {
            console.log('THERES AN ERROR');
            console.log(xhr);
        }
    });
}

function mrktBuy() {
    var pList = "";
    var portfolio = localStorage.getItem("idPortfolio");

    $.ajax({
        url: "../DB/marketList.php",
        type: "get", //send it through get method
        data: {
            ajaxid: 4,
            username: userid ,
            portfolioname: portfolio,
        },
        success: function(response) {
            let dataP = JSON.parse(response);

            console.log(dataP.records);
            console.log(dataP);

            for (var i = 0; i < dataP.records.length; i++) {

                /*if(dataP[i]===0){
                    dataP[i+2]='INACTIVE';
                }*/

                list = `<tr id="${dataP.records[i].symbol}" onclick="inputSymM(this.id)" >
                         <td>${dataP.records[i].symbol}</td>
                         <td class="list">${dataP.records[i].company_name}</td>
                         <td class="list" style="color:slateblue">${parseFloat(dataP.records[i].current_price).toFixed(2)}</td>
                        </tr>`;
                pList += list;
            }
            $('#dropdownB').html(pList);

            $("td.list").each(function(){
                if($(this).html() === 'INACTIVE') $(this.parentNode).attr("onclick",'').hover(function () {
                    $(this).css('background-color', 'crimson')}, function () {
                    $(this).css('background-color', 'ghostwhite')});

            })
        },
        error: function(xhr) {
            console.log('THERES AN ERROR');
            console.log(xhr);
        }
    });

}