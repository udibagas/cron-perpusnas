<?php
require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';

$modbus = new ModbusMaster("192.168.99.110", "TCP");

$nilaioffset = 120;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(1, $nilaioffset, 68);
}
catch (Exception $e) {
    echo "ngawur ni";
    exit;
}
	$hitung = $nilaioffset-1;
	$values = array_chunk($recData, 4 );
	
	foreach($values as $bytes) {
	$hitung=$hitung+2;
	$alamatmemori = 40000+$hitung;
	$nilaisensor = PhpType::bytes2float($bytes);
	echo "Isi $hitung = $nilaisensor \n";

	}

?>
