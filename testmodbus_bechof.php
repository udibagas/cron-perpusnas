
<?php
require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';
include "koneksi.php";

$modbus = new ModbusMaster("192.168.99.110", "TCP");
	$ppp = 0;
$nilaioffset = 02;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(1, $nilaioffset, 91);
}
catch (Exception $e) {
    echo "ngawur ni";
    exit;
}
	$hitung = $nilaioffset-1;
	$values = array_chunk($recData, 4 );
	
	foreach($values as $bytes) {
	$hitung=$hitung+2;
	$alamatmemori = $hitung+40000;
	$nilaisensor = PhpType::bytes2float($bytes);
	echo "Isi $alamatmemori = $nilaisensor \n";
	
	$sql=$konek->query("SELECT ID_SENSOR FROM sensor WHERE LEFT(KODEALAT,7)='Listrik' ORDER BY ID_SENSOR ASC LIMIT $ppp,1");
		$data = $sql->fetch_assoc();
		$id = $data['ID_SENSOR'];
	
	$sql1 = $konek->query("SELECT PARAMETER FROM sensor WHERE ID_SENSOR='$id'");
			$cek=$sql1->fetch_assoc();
			$param = trim($cek['PARAMETER']);	

				
			$pesan="";
	if(substr($param,0,6=="Active")){
		$nilaisensor=$nilaisensor/1000;
	};	

		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$nilaisensor','$pesan','Y')");

	echo "$id\n";
	$ppp=$ppp+1;

	}
	
	sleep(1);
	
	$modbus = new ModbusMaster("192.168.99.110", "TCP");

$nilaioffset = 94;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(1, $nilaioffset, 91);
}
catch (Exception $e) {
    echo "ngawur ni";
    exit;
}
	$hitung = $nilaioffset-1;
	$values = array_chunk($recData, 4 );
	

		
	
	foreach($values as $bytes) {
	$hitung=$hitung+2;
	$alamatmemori = $hitung+40000;
	$nilaisensor = PhpType::bytes2float($bytes);
	
	$sql=$konek->query("SELECT ID_SENSOR FROM sensor WHERE LEFT(KODEALAT,7)='Listrik' ORDER BY ID_SENSOR ASC LIMIT $ppp,1");
		$data = $sql->fetch_assoc();
		$id = $data['ID_SENSOR'];
	
		
	$sql1 = $konek->query("SELECT PARAMETER FROM sensor WHERE ID_SENSOR='$id'");
			$cek=$sql1->fetch_assoc();
			$param = trim($cek['PARAMETER']);	

				
			$pesan="";
	if(substr($param,0,6=="Active")){
		$nilaisensor=$nilaisensor/1000;
	};	
	
	

		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$nilaisensor','$pesan','Y')");

	echo "$id\n";
	$ppp=$ppp+1;
	}

?>
