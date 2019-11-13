<html lang="en">
<table style="width: 100%; text-align: center" class="main" id="performTab">
</table>
<br><br><br><br><br>
<script>
    $(document).ready(function(){

        var portfolio = localStorage.getItem("idPortfolio");

        $.post("../DB/performBK.php",
                {
                    username: userid ,
                    portfolioname: portfolio,
                },
                function(data, status){ //will need to parse
                    console.log(data);
                    console.log(status);
                    console.log(JSON.parse(data));
                    let dataP = JSON.parse(data);

                    var pList = '<tr id="th">\n' +
                        '        <th>Symbol</th>\n' +
                        '        <th>Company Name</th>\n' +
                        '        <th>Buy Price</th>\n' +
                        '        <th>Buy Date</th>\n' +
                        '        <th>Shares</th>\n' +
                        '        <th>Current Price</th>\n' +
                        '        <th>Currency</th>\n' +
                        '        <th>Gain/Loss</th>\n' +
                        '        <th>Net Asset Value</th>\n' +
                        '    </tr>';
                    for (var i = 0; i < dataP.length; i+=9) {

                        for(var j = 0; j < 9; j++){
                            if (dataP[i+j]===null)
                                dataP[i+j]='';
                        }

                        /*if(parseFloat(dataP[i+7]) < 0){
                            ('#p'+(i+7)).css('color','crimson')
                        } else {
                            ('#p'+(i+7)).css('color','limegreen')
                        }
                        if(parseFloat(dataP[i+8]) < 0){
                            ('#p'+(i+8)).css('color','crimson')
                        } else {
                            ('#p'+(i+8)).css('color','limegreen')
                        }*/

                        list = `<tr id="${dataP[i]}">
                                    <td class="p">${dataP[i]}</td>
                                    <td class="p">${dataP[i+1]}</td>
                                    <td class="p">${dataP[i+2]}</td>
                                    <td class="p">${dataP[i+3]}</td>
                                    <td class="p">${dataP[i+4]}</td>
                                    <td class="p">${dataP[i+5]}</td>
                                    <td class="p">${dataP[i+6]}</td>
                                    <td class="pd" id="p${i+7}">${dataP[i+7]}</td>
                                    <td class="pd" id="p${i+8}">${dataP[i+8]}</td>
                                </tr>`;
                        pList += list;
                    }
                    $('#performTab').html(pList);

                    $("td.p").each(function(){
                        if($(this).html() === "") $(this).css('background-color', 'lightsteelblue');
                    });
                    $(".pd").each(function(){
                        if($(this).html() === "") $(this).css('background-color', 'lightsteelblue');

                        var val = $(this).html();
                        var pFval = parseFloat(val);

                        if(pFval < 0) $(this).css('color', 'crimson');
                        else $(this).css('color', 'limegreen');
                    });
                });
    });
</script>
</html>