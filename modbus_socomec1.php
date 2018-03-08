
<h1 align="center">Test listrik1 </h1><br>
<?php
require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';

$modbus = new ModbusMaster("192.168.99.155", "TCP");

$nilaioffset = 51672;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(5, $nilaioffset, 50);
}
catch (Exception $e) {
    echo "ngawur ni";
    exit;
}
$hitung = $nilaioffset-2;
$values = array_chunk($recData, 2);

		// ini bagian forecch nya
foreach($values as $bytes) {
$hitung=$hitung+1;
    $nilai = PhpType::bytes2unsignedInt($bytes);
  

   
    echo "nilai ke $hitung : $nilai \n";
	

	}

	//tttt

	$nilaioffset = 50544;  // nilai offset asli dikurang 1

