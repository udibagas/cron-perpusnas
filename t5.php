<?php
include "koneksi.php";

$konek->query("INSERT INTO trans15menit (SELECT null,ID_SENSOR,CURDATE() as tanggal,CURTIME() as jam,
MIN(trans5.nilai) as min,
MAX(trans5.nilai) as max,
AVG(trans5.nilai) as rata,
('Y') as koneksi FROM
(select * from trans5 order by trans5.ID_SENSOR, trans5.tgljam desc) trans5
 GROUP BY ID_SENSOR)");
?>
