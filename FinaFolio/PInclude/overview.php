<html lang="en">
<table style="width: 100%; text-align: center" class="main" id="overTab">
</table>
<br><br><br><br><br>
<script>
    $(document).ready(function(){
        var portfolio= localStorage.getItem("idPortfolio");
        $.post("../DB/overvBK.php",
            {
                username: userid ,
                portfolioname: portfolio
            },
            function(data, status){ //will need to parse
                console.log(JSON.parse(data));
                console.log(status);

                let dataP = JSON.parse(data);

                var pList = '<tr id="th">\n' +
                    '        <th>Symbol</th>\n' +
                    '        <th>Company Name</th>\n' +
                    '        <th>Last Price</th>\n' +
                    '        <th>Change</th>\n' +
                    '        <th>Change %</th>\n' +
                    '        <th>Volume</th>\n' +
                    '    </tr>';
                for (let i = 0; i < dataP.overview.length; i++) {

                    list = `<tr id="${dataP.overview[i].symbol}">
                                    <td>${dataP.overview[i].symbol}</td>
                                    <td>${dataP.overview[i].company_name}</td>
                                    <td>${parseFloat(dataP.overview[i].usd_price).toFixed(2)}</td>
                                    <td class="o" id="o">${dataP.overview[i].change}</td>
                                    <td class="o" id="o">${dataP.overview[i].percent_change}</td>
                                    <td>${dataP.overview[i].volume}</td>
                                </tr>`;
                    pList += list;
                }
                $('#overTab').html(pList);

                $(".o").each(function(){
                    var val = $(this).html();
                    var pFval = parseFloat(val);

                    if(pFval < 0) $(this).css('color', 'crimson');
                    else $(this).css('color', 'limegreen');
                });
            });

    });
</script>
</html>