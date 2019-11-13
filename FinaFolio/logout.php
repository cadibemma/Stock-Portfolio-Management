<?php
session_start();
$_SESSION = array();

echo $_SESSION['username'];
session_unset();
session_destroy();

header("Location:../");

exit();