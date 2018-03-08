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

// RAK 2
$query = $konek->query("select * from sensor where parameter = 'Arus' and posisidetail like 'rak-02'");
$sensor = $query->fetch_assoc();
$q = $konek->query("insert into trans5 (ID_SENSOR, tgljam, nilai, pesan, koneksi) VALUES ({$sensor['ID_SENSOR']}, NOW(), 1.1, '', 'Y')");
echo $sensor["PARAMETER"]." ".$sensor["NAMALOKASI"]." ".$sensor["POSISIDETAIL"]." = 1.1"."\n";

// RAK 3
$query = $konek->query("select * from sensor where parameter = 'Arus' and posisidetail like 'rak-03'");
$sensor = $query->fetch_assoc();
$q = $konek->query("insert into trans5 (ID_SENSOR, tgljam, nilai, pesan, koneksi) VALUES ({$sensor['ID_SENSOR']}, NOW(), 0.3, '', 'Y')");
echo $sensor["PARAMETER"]." ".$sensor["NAMALOKASI"]." ".$sensor["POSISIDETAIL"]." = 0.3"."\n";
