
<?php
include_once "koneksi.php";

$pesan="";

$query = $konek->query("SELECT DISTINCT IPADDR FROM sensor WHERE LEFT(KODEALAT,7)='Listris'");
while($d=$query->fetch_array()){

echo "$d[IPADDR] \n";

$sql=$konek->query("SELECT * FROM sensor WHERE IPADDR='$d[IPADDR]' AND LEFT(PARAMETER,7)='Voltage' ORDER BY VARIABELPROTOCOL ASC");
$nomor = $sql->num_rows;

$data = $sql->fetch_assoc();
$var= $data['VARIABELPROTOCOL'];
$offend = $nomor*2;
$ip=$data['IPADDR'];


require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';

$modbus = new ModbusMaster($ip, "TCP");

$nilaioffset = $var;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(5, $nilaioffset, $offend);
}
catch (Exception $e) {
    echo "ngawur ni";
    //exit;
}
	$hitung = $nilaioffset-2;
	$values = array_chunk($recData, 2 );
	
	foreach($values as $bytes) {

	$hitung=$hitung+1;
    $nilai = PhpType::bytes2unsignedInt($bytes);
  

    if(($hitung % 2)==0){
	echo "voltage - nilai ke $hitung : $nilai \n";
    	$nilai=$nilai/100;
		
		$sql=$konek->query("SELECT ID_SENSOR FROM sensor WHERE LEFT(KODEALAT,7)='Listris' AND VARIABELPROTOCOL='$hitung' AND IPADDR='$d[IPADDR]' ORDER BY ID_SENSOR ASC LIMIT 1");
		$data = $sql->fetch_assoc();
		$id = $data['ID_SENSOR'];
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$nilai','$pesan','Y')");
	}
	
	}
	
$warnakeliling = "ffffff";
	
$arr = array();


$sql=$konek->query("SELECT * FROM sensor WHERE IPADDR='$d[IPADDR]' AND LEFT(PARAMETER,6)='Active' ORDER BY VARIABELPROTOCOL ASC");
$nomor = $sql->num_rows;

$data = $sql->fetch_assoc();
$var= $data['VARIABELPROTOCOL'];
$offend = $nomor*2;
$ip=$data['IPADDR'];

require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';

$modbus = new ModbusMaster($ip, "TCP");

$nilaioffset = $var;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(5, $nilaioffset, $offend);
}
catch (Exception $e) {
    echo "ngawur ni";
    //exit;
}
	$hitung = $nilaioffset-2;
	$values = array_chunk($recData, 2 );
	
	foreach($values as $bytes) {

	$hitung=$hitung+1;
    $nilai = PhpType::bytes2unsignedInt($bytes);
  

    if(($hitung % 2)==0){
    echo "Active - nilai ke $hitung : $nilai \n";
    	$nilai=$nilai/100;
		$sql=$konek->query("SELECT ID_SENSOR FROM sensor WHERE LEFT(KODEALAT,7)='Listris' AND VARIABELPROTOCOL='$hitung' AND IPADDR='$d[IPADDR]' ORDER BY ID_SENSOR ASC LIMIT 1");
		$data = $sql->fetch_assoc();
		$id = $data['ID_SENSOR'];
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$nilai','$pesan','Y')");
	}
	
	}
	
$warnakeliling = "ffffff";
	
$arr = array();


$sql=$konek->query("SELECT * FROM sensor WHERE IPADDR='$d[IPADDR]' AND PARAMETER='Frequency' ORDER BY VARIABELPROTOCOL ASC");
$nomor = $sql->num_rows;

$data = $sql->fetch_assoc();
$var= $data['VARIABELPROTOCOL'];
$offend = $nomor*2;
$ip=$data['IPADDR'];

require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';

$modbus = new ModbusMaster($ip, "TCP");

$nilaioffset = $var;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(5, $nilaioffset, $offend);
}
catch (Exception $e) {
    echo "ngawur ni";
    //exit;
}
	$hitung = $nilaioffset-2;
	$values = array_chunk($recData, 2 );
	
	foreach($values as $bytes) {

	$hitung=$hitung+1;
    $nilai = PhpType::bytes2unsignedInt($bytes);
  

    if(($hitung % 2)==0){
    echo "Freq - nilai ke $hitung : $nilai \n";
    	$nilai=$nilai/100;
		$sql=$konek->query("SELECT ID_SENSOR FROM sensor WHERE LEFT(KODEALAT,7)='Listris' AND VARIABELPROTOCOL='$hitung' AND IPADDR='$d[IPADDR]' ORDER BY ID_SENSOR ASC LIMIT 1");
		$data = $sql->fetch_assoc();
		$id = $data['ID_SENSOR'];
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$nilai','$pesan','Y')");
	}
	
	}?>
		<?php
	
$arr = array();


$sql=$konek->query("SELECT * FROM sensor WHERE IPADDR='$d[IPADDR]' AND LEFT(PARAMETER,7)='Current' ORDER BY VARIABELPROTOCOL ASC");
$nomor = $sql->num_rows;

$data = $sql->fetch_assoc();
$var= $data['VARIABELPROTOCOL'];
$offend = $nomor*2;
$ip=$data['IPADDR'];

require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';

$modbus = new ModbusMaster($ip, "TCP");

$nilaioffset = $var;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(5, $nilaioffset, $offend);
}
catch (Exception $e) {
    echo "ngawur ni";
    //exit;
}
	$hitung = $nilaioffset-2;
	$values = array_chunk($recData, 2 );
	
	foreach($values as $bytes) {

	$hitung=$hitung+1;
    $nilai = PhpType::bytes2unsignedInt($bytes);
  

    if(($hitung % 2)==0){
    echo "Current - nilai ke $hitung : $nilai \n";
    	$nilai=$nilai/1000;
		$sql=$konek->query("SELECT ID_SENSOR FROM sensor WHERE LEFT(KODEALAT,7)='Listris' AND VARIABELPROTOCOL='$hitung' AND IPADDR='$d[IPADDR]' ORDER BY ID_SENSOR ASC LIMIT 1");
		$data = $sql->fetch_assoc();
		$id = $data['ID_SENSOR'];
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$nilai','$pesan','Y')");
	}
	
	}
	
	echo "\n \n";
	

	?>
	
	
	<?php
	
$arr = array();


$sql=$konek->query("SELECT * FROM sensor WHERE IPADDR='$d[IPADDR]' AND LEFT(PARAMETER,7)='Harmoni' ORDER BY VARIABELPROTOCOL ASC");
$nomor = $sql->num_rows;

$data = $sql->fetch_assoc();
$var= $data['VARIABELPROTOCOL'];
$offend = $nomor;
$ip=$data['IPADDR'];

if($nomor>0){

require_once dirname(__FILE__) . '/Phpmodbus/ModbusMaster.php';

$modbus = new ModbusMaster($ip, "TCP");

$nilaioffset = $var;  // nilai offset asli dikurang 1

try {
    $recData = $modbus->readMultipleRegisters(5, $nilaioffset, $offend);
}
catch (Exception $e) {
    echo "ngawur ni";
    //exit;
}
	$hitung = $nilaioffset-1;
	$values = array_chunk($recData, 2 );
	
	foreach($values as $bytes) {

	$hitung=$hitung+1;
    $nilai = PhpType::bytes2unsignedInt($bytes);


    	$nilai=$nilai;
		$sql=$konek->query("SELECT ID_SENSOR FROM sensor WHERE LEFT(KODEALAT,7)='Listris' AND VARIABELPROTOCOL='$hitung' AND IPADDR='$d[IPADDR]' ORDER BY ID_SENSOR ASC LIMIT 1");
		$data = $sql->fetch_assoc();
		$id = $data['ID_SENSOR'];
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$nilai','$pesan','Y')");
echo "Harmoni - nilai ke $hitung : $nilai \n ";
	
	
	echo "INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ('$id',NOW(),'$nilai','$pesan','Y')";
	
	}
	
	echo "\n \n";
}
}
	?>
	
