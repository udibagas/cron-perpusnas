<?php
function bacapanelsch($reg1, $reg2) {
	$reg1a = floor($reg1/256);
	$reg1b = floor($reg1 - $reg1a*256);
	$reg2a = floor($reg2/256);
	$reg2b = floor($reg2 - $reg2a*256);
	$reg1abin = decbin($reg1a); $reg1abin = substr("00000000",0,8 - strlen($reg1abin)) . $reg1abin;
	$reg1bbin = decbin($reg1b); $reg1bbin = substr("00000000",0,8 - strlen($reg1bbin)) . $reg1bbin;
	$reg2abin = decbin($reg2a); $reg2abin = substr("00000000",0,8 - strlen($reg2abin)) . $reg2abin;
	$reg2bbin = decbin($reg2b); $reg2bbin = substr("00000000",0,8 - strlen($reg2bbin)) . $reg2bbin;
	$digit1reg1abin = substr($reg1abin,0,1);
   if($digit1reg1abin == 0) { $nilaiutkhasil1 = 1; } else { $nilaiutkhasil1 = 0; };
	$potonganreg1a1bbin = substr($reg1abin,1,7) . substr($reg1bbin,0,1);
	$potonganreg1a1bdec = bindec($potonganreg1a1bbin);
	$nilaiutkhasil2 = $potonganreg1a1bdec - 127;
	$a = bindec(substr($reg1bbin,1,7))*256*256;
	$b = bindec($reg2abin)*256;
	$c = bindec($reg2bbin);
	$decreg1a2a2b = $a + $b + $c;
	$hex800rb = $decreg1a2a2b/8388608 + 1;
	$hex400rb = $decreg1a2a2b/4194304;
   if($potonganreg1a1bdec > 0) { $nilaiutkhasil3 = $hex800rb; } else { $nilaiutkhasil3 = $hex400rb; };
	$nilaisebenarnya = $nilaiutkhasil1 * $nilaiutkhasil3 * pow(2,$nilaiutkhasil2);
	return $nilaisebenarnya;
};

require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';

include "koneksi.php";

$sql=$konek->query("SELECT DISTINCT IPADDR FROM sensor WHERE LEFT(KODEALAT,7)='Listrik'");
while($data=$sql->fetch_array()){
$ip = $data['IPADDR'];
echo "\n $ip \n";
$modbus = new ModbusMaster($ip, "TCP");

$nilaioffset = 3000; 
$nilaioffset = $nilaioffset -1;
$tujuan = 120;

try {
    $recData = $modbus->readMultipleRegisters(1, $nilaioffset, $tujuan);
}
catch (Exception $e) {
    echo "Data tidak bisa dipanggil";
    //exit;
}
$hitung = $nilaioffset ;
$values = array_chunk($recData, 2);

// ini bagian forecch nya
foreach($values as $bytes) {
	$hitung=$hitung+1;
    $nilai = PhpType::bytes2unsignedInt($bytes);
    $nilaiofset = $hitung + 40000;
	$hitung1 = $hitung-1;

	if(($hitung % 2)==1){
		$hasil = bacapanelsch($reg, $nilai);
		
		if($hitung1==3000 || $hitung1==3002 || $hitung1==3004 || $hitung1==3020 || $hitung1==3022 || $hitung1==3024 || $hitung1==3028 || $hitung1==3030 || $hitung1==3032 || $hitung1==3054 || $hitung1==3056 || $hitung1==3058 || $hitung1==3110){
		
		$cek = $hitung1+40000;
		echo "$cek dari( $reg $nilai ) -> $hasil \n";
		$sql1=$konek->query("SELECT * FROM sensor WHERE IPADDR='$ip' AND VARIABELPROTOCOL='$cek' ORDER BY ID_SENSOR ASC");
		while($data=$sql1->fetch_array()){
		
		$id = $data['ID_SENSOR'];
		$lok = $data['NAMALOKASI'];
		$pos = $data['POSISIDETAIL']; 
		
		$pesan="";
		
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$hasil','$pesan','Y')");
		
		}
		
		}
	}
	$reg = $nilai;
	
	
	}
}
?>





