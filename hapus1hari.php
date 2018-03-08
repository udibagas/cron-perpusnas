<?php
include "koneksi.php";

$sql=$konek->query("INSERT INTO pue(SELECT null,CURDATE(),(
((SELECT AVG(nilai) FROM trans5 WHERE ID_SENSOR='130')+(SELECT AVG(nilai) FROM trans5 WHERE ID_SENSOR='131')+(SELECT AVG(nilai) FROM trans5 WHERE ID_SENSOR='132')) 
/
((SELECT AVG(nilai) FROM trans5 WHERE ID_SENSOR='104')+(SELECT AVG(nilai) FROM trans5 WHERE ID_SENSOR='105')+(SELECT AVG(nilai) FROM trans5 WHERE ID_SENSOR='106')
+(SELECT AVG(nilai) FROM trans5 WHERE ID_SENSOR='117')+(SELECT AVG(nilai) FROM trans5 WHERE ID_SENSOR='118')+(SELECT AVG(nilai) FROM trans5 WHERE ID_SENSOR='119')) 
) as nilai)");

$konek->query("INSERT INTO trans1hari (SELECT null,ID_SENSOR,CURDATE() as tanggal,MIN(trans15menit.min) as min,MAX(trans15menit.max) as max,AVG(trans15menit.rata) as rata,('Y') as koneksi FROM (select * from trans15menit order by trans15menit.ID_SENSOR, trans15menit.tanggal desc) trans15menit GROUP BY ID_SENSOR)");

$konek->query("TRUNCATE table trans15menit");

 ?>
