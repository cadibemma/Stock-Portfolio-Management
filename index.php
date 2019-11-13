<!DOCTYPE html>
<html lang="en" style="background-color: ghostwhite">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Layout/ind.css">
    <script src="https://code.jquery.com/jquery-3.1.1.js" ></script>

    <title>Login to FinaFolio</title>
</head>
<style>
    html {
        height: 100%;
        margin: 0;
        padding: 0;
        max-height: 100%;
        background-image: url('Layout/wall/wall2.jpg');
        background-size:100% 100%;
        background-repeat: repeat-y;
    }
    .box {
        background-color: rgba(255,255,255, 0.45);
        position: absolute;
        top: 25%;
        left: 40%;
        padding: 75px 25px 75px;
        margin-top: 0;
        margin-bottom: 0;
        border-radius:25px;
        border: 3px solid lavender;
    }
    .enter:hover{
        background-color:lavender;
        border-radius: 25px;
    }
</style>
<body>
<b><center class="fiLogin">FinaFolio</center></b>
<br>
<section class="box">
    <form id="loginForm">
        <center style="font-size:x-large"><b><u>Login</u></b></center>
        <br><br>
        <center>Username: <input name="username" id="username" type="text" required autocomplete=off></center>
        <center>Password: <input name="password" id="password" type="password" required autocomplete=off></center>
        <br>
        <center><input type="button" value="Login" class="enter" onclick="login()"></center>
        <br>
        <center><div id="verify" style="color: crimson; font-weight: 100"></div></center>
        <br>
        <i>Don't have an account?</i>
        <br><br>
        <center><input type="button" onclick="joinNow();" value="Create Account" class="enter"></center>
    </form>
</section>
</body>
<script>
    function joinNow() {
        location.href="join.php"
    }
    document.getElementById('username').onkeydown = function(event) {
        if (event.keyCode === 13) {
            login();
        }
    };
    document.getElementById('password').onkeydown = function(event) {
        if (event.keyCode === 13) {
            login();
        }
    };
    function login() {

        var user = document.getElementById("username").value;
        var pass = document.getElementById("password").value;

        if(user === "" || pass === "") {
            $('#verify').html("Field cannot be left blank");
        }else{
            $.post("DB/login.php",
                {
                    username: user,
                    password: pass
                },
                function(data, status){

                    $('#verify').html(data).css("color","limegreen");

                    console.log(data);
                    console.log(status);

                    if (data === "Login Success"){
                        window.location.href ="FinaFolio/home.php";
                    }else {
                        $('#verify').css("color","crimson");
                    }
                });
        }
    }
</script>
</html>