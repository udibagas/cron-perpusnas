<?php

include "koneksi.php";

// get sensor with parameter Suhu & Lembab
$query = $konek->query("select * from sensor where (parameter = 'Suhu' or parameter = 'Lembab') and posisidetail like 'rak%'");

while ($sensor = $query->fetch_array()) {
    // insert to database
    $nilai = ($sensor["PARAMETER"] == "Suhu") ? rand(18, 21) : rand(45, 50);
    $q = $konek->query("insert into trans5 (ID_SENSOR, tgljam, nilai, pesan, koneksi) VALUES ({$sensor['ID_SENSOR']}, NOW(), $nilai, '', 'Y')");
    echo $sensor["PARAMETER"]." ".$sensor["NAMALOKASI"]." ".$sensor["POSISIDETAIL"]." = ".$nilai."\n";
}
