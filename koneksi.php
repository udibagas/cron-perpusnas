<?php

$host = "127.0.0.1";
$user = "root";
$pass = "bismillah";
$db   =	"unitron_perpusnas";
$konek = new mysqli($host,$user,$pass,$db, 3307);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>
