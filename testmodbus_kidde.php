
<?php

require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';
include_once "koneksi.php";
$modbus = new ModbusMaster("10.4.2.202", "TCP");
echo "10.4.2.202";
	$ppp = 0;
$nilaioffset = 7;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(1, $nilaioffset, 80);
}
catch (Exception $e) {
    echo "ngawur ni \n $e";
	
 //$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('00',NOW(),'0','Error','N')");
    exit;
}
$hitung = $nilaioffset+40000;
$values = array_chunk($recData, 2);

		// ini bagian forecch nya
foreach($values as $bytes) {
$hitung=$hitung+1;
    $nilai = PhpType::bytes2unsignedInt($bytes);
   // $nilaiofset = $hitung + 40000;
    $nilaibiner = decbin($nilai);
    $nilaibiner = substr("00000000",0,8 - strlen($nilaibiner)) . $nilaibiner;
    $alat = substr($nilaibiner, -3);
    $alarm = substr($nilaibiner, -5, 1);
	
	//echo "$hitung -> $alarm \n";
	if($alarm=='1'){
	echo "alaram! -- ";
}	
$hitung1 = $hitung-8;
	$sql=$konek->query("SELECT ID_SENSOR,NAMALOKASI,POSISIDETAIL FROM sensor WHERE PARAMETER='Gas' AND PROTOCOL='MODBUSTCP' AND VARIABELPROTOCOL='$hitung1' ORDER BY ID_SENSOR ASC ");
		$data = $sql->fetch_assoc();
		$id = $data['ID_SENSOR'];
		$lok = $data['NAMALOKASI'];
		$pos = $data['POSISIDETAIL']; 
	if($alarm==0){
		$pesan = "";
	}else{
		$pesan="Alert Gas $lok -> $pos !!";
	}
	if(trim($lok)!=""){
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$alarm','$pesan','Y')");
		
	$ppp=$ppp+1;
	echo "$id - >$hitung1 -> $alarm -> $pesan -> $lok ->$pos \n";
	
	//echo "INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$alarm','$pesan','Y') \n";
	}
	}

?>

