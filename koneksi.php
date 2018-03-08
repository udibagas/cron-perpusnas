<?php

$host = "localhost";
$user = "root";
$pass = "uni123";
$db   =	"unique";
$konek = new mysqli($host,$user,$pass,$db);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>
