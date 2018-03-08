
<h1 align="center">Test listrik1 </h1><br>
<?php
require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';

$modbus = new ModbusMaster("10.10.20.110", "TCP");

$nilaioffset = 50514;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(5, $nilaioffset, 22);
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
  

    if(($hitung % 2)==0){
    echo "nilai ke $hitung : $nilai <br>";
	}

	}

	//tttt

	$nilaioffset = 50544;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(5, $nilaioffset, 6);
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
  

    if(($hitung % 2)==0){
    echo "nilai ke $hitung : $nilai <br>";
	}

	}

	//---------------

	$nilaioffset = 50556;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(5, $nilaioffset, 6);
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
  

    if(($hitung % 2)==0){
    echo "nilai ke $hitung : $nilai <br>";
	}

	}


?>


