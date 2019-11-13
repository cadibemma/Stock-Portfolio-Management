<!DOCTYPE html>
<html lang="en" style="background-color: ghostwhite">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.1.1.js" ></script>

    <title> Create Account</title>
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
        border-radius:25px;
        border: 3px solid lavender;
    }
    .enter:hover{
        background-color:lavender;
        border-radius: 25px;
    }
</style>
<body>
<section class="box">
    <center><b><u>Create Account</u></b></center>
    <br><br>
    <form action="DB/create_user.php" id="createForm" method="post">
        <center>First Name: <input id="firstname" type="text"></center>
        <center>Last Name: <input id="lastname" type="text"></center>
        <center>Username: <input id="username" type="text"></center>
        <br>
        <center>Password:<input id="password" type="password"></center>
        Re-enter Password: <input id="repassword" type="password">
        <br><br>
        <center><div id="check" style="color:crimson; font-weight: 100"></div></center>
        <br>
        <center><input type="button" value="Sign Up" class="enter" onclick="signUp();"></center>
        <br>
        <i>Already have an account? Click <a href="https://web.njit.edu/~cla22/t1">here</a></i>
    </form>
</section>
</body>
<script>
    function signUp() {
        var pass = document.getElementById("password").value;
        var rePass = document.getElementById("repassword").value;

        var first = document.getElementById("firstname").value;
        var last = document.getElementById("lastname").value;
        var username = document.getElementById("username").value;

        if(first === "" || last === "" || username === "" || pass === "" || pass === "") {
            $('#check').html("Field cannot be left blank");
        }else {
            if (pass !== rePass) {
                $('#check').html("Password does not match");
            } else {
                $.post("DB/create_user.php",
                    {
                        username: username,
                        password: pass,
                        firstname: first,
                        lastname: last
                    },
                    function(data, status){

                        $('#check').html(data).css("color","limegreen");
                        console.log(data);
                        console.log(status);

                        if (data === "Account created! Now you may Login"){
                            window.location.href ="index.php";
                        } else {
                            $('#check').css("color","crimson");
                        }
                    });
            }
        }
    }
</script>
</html>
