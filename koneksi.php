<?php

$host = "localhost";
$user = "root";
$pass = "bismillah";
$db   =	"unitron_perpusnas";
$konek = new mysqli($host,$user,$pass,$db);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>
