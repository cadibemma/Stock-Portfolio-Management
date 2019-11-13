<html lang="en">
<ul style="list-style-type: none; font-size: 15px; margin-top: 7%;">
    <label>Portfolios</label>
    <div>
        <ul style="list-style-type: none;" id="pList">
        </ul>
    </div>

</ul>
<script type="text/javascript">
    $(document).ready(function(){
        var pList = "";
            $.post("../DB/portfolioList.php",
                {
                    username: userid
                },
                function(data, status){

                if (data !== "NONE") {
                    var idP = localStorage.getItem("idPortfolio");

                    let dataP = JSON.parse(data);



                    for (var i = 0; i < dataP.length; i++) {

                        let str = dataP[i];
                        str = str.replace(/_/g, " ");
                        list = `<li onclick="pLoad(this.id);" style="font-size: small" id="${dataP[i]}">${str.toUpperCase()}</li>`;
                        pList += list;
                    }
                    $('#pList').html(pList);
                    $('#'+idP).css("color", "crimson");
                }

            });
    });
</script>
</html>