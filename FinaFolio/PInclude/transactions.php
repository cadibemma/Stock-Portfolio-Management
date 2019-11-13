<html lang="en">
<table style="width: 100%; text-align: center" class="main" id="transTab">
</table>
<br><br><br><br><br>
<script>
    $(document).ready(function(){
        var portfolio= localStorage.getItem("idPortfolio");
        $.post("../DB/transacBK.php",
                {
                    username: userid ,
                    portfolioname: portfolio
                },
                function(data, status) { //will need to parse
                    console.log(JSON.parse(data));
                    console.log(status);

                    let dataP = JSON.parse(data);

                    var pList = '<tr id="th">\n' +
                        '        <th>Symbol</th>\n' +
                        '        <th>Company Name</th>\n' +
                        '        <th>Type</th>\n' +
                        '        <th>Timestamp</th>\n' +
                        '        <th>Shares</th>\n' +
                        '        <th>Total Price</th>\n' +
                        '        <th>Amount</th>\n' +
                        '    </tr>';
                    for (var i = 0; i < dataP.length; i += 7) {

                        for (var j = 0; j < 7; j++) {
                            if (dataP[i + j] === null) {
                                dataP[i + j] = '';
                                num = i + j;
                            }
                        }

                        if(dataP[i+2].toLowerCase() === 'withdrawal'){
                            dataP[i+6]= '$'+ dataP[i+6];
                        }
                        if(dataP[i+2].toLowerCase() === 'deposit'){
                            dataP[i+6]= '$'+ dataP[i+6];
                        }
                        if(dataP[i+2].toLowerCase() === 'buy' || dataP[i+2].toLowerCase() === 'sell'){
                            dataP[i+5]= '$'+ dataP[i+5];
                        }

                            list = `<tr id="${dataP[i + 1]}">
                                    <td class="t">${dataP[i + 1]}</td>
                                    <td class="t">${dataP[i]}</td>
                                    <td class="t">${dataP[i + 2]}</td>
                                    <td class="t">${dataP[i + 3]}</td>
                                    <td class="t">${dataP[i + 4]}</td>
                                    <td class="t">${dataP[i + 5]}</td>
                                    <td class="t">${dataP[i + 6]}</td>
                                </tr>`;
                        pList += list;

                    }
                    $('#transTab').html(pList);

                    $("td.t").each(function(){
                        if($(this).html() === "" && ($(this).prev().prev().text() !== 'Deposit' &&
                            $(this).prev().prev().prev().text() !== 'Deposit' && $(this).prev().prev().text() !== 'Withdrawal' &&
                            $(this).prev().prev().prev().text() !== 'Withdrawal')) $(this).css('background-color', 'lightsteelblue');
                    })

                });
    });
</script>
</html>