<!DOCTYPE html>
<?php include "sess.php" ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Layout/ind.css">
    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="portfolio.js" lang="JavaScript"></script>

    <title>FinaFolio</title>
    <?php include "nav.php" ?>
</head>
<style>
    html {
        height: 100%;
        margin: 0;
        padding: 0;
        max-height: 100%;
        background-image: url('../Layout/wall/wall2.jpg');
        background-size:100% 100%;
        background-repeat: repeat-y;
        font-family: Georgia,sans-serif;
    }
    table {
        font-family: Georgia, sans-serif;
        border-collapse: collapse;
    }
    .main td, .main th {
        border: 1px solid lavender;
    }
    td {
        padding: 6px;
    }
    .main tr:nth-child(even) {
        background-color: lavender;
    }
    .main tr:nth-child(odd) {
        background-color: ghostwhite;
    }
    input {
        font-family: Georgia, sans-serif;
    }
</style>
<body>
<div class="sidenav" id="sideSel"><?php include "sidepList.php" ?></div>
<div style="display: inline-block; margin-left: 20.5%; width: 79%;" id="page">
    <?php include "portfolio.php"?>
</div>
</body>
<script>

    function tView(id) {


        let overv = document.getElementById('overv');
        let perform = document.getElementById('perform');
        let transac = document.getElementById('transac');

        if (id === 'overv') {

            $('#tableV').load("PInclude/overview.php");

            overv.style.color = "black";
            perform.style.color = "blue";
            transac.style.color = "blue";
        }
        else if (id === 'perform'){

            $('#tableV').load("PInclude/performance.php");

            overv.style.color = "blue";
            perform.style.color = "black";
            transac.style.color = "blue";
        }
        else{

            $('#tableV').load("PInclude/transactions.php");

            overv.style.color = "blue";
            perform.style.color = "blue";
            transac.style.color = "black";
        }

    }
</script>
</html>