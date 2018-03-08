<?php 

	include "crongenset.php";
	include_once "koneksi.php";
 
 $stockquotes = $data;
 //echo nl2br($stockquotes);
 $baris = explode("\n", $stockquotes);
 
	
 for ($i=0;$i<count($baris);$i++)
 {
  list($id,$opt,$ip,$var)= explode(",", $baris[$i]);
 $var = trim($var); 
 $opt = trim($opt);
 $ip = trim($ip);
  $shell = "/usr/bin/snmpget $opt $ip $var 2>&1";

		
		
		$run = shell_exec($shell);
		$len = strlen($run);
		if($var=="bacaJarak"){
				if(strlen($run)==33){			
					$nilai = substr($run,-3);
				}elseif(strlen($run)==34){
					$nilai = substr($run,-4);	
				}elseif(strlen($run)==35){
					$nilai = substr($run,-5);	
				}else{
					$nilai = substr($run,-3);
				}
		}else{
		$nilai = substr($run,-3);
			
		}
		$nilai = trim($nilai);
		
		$cek2 = substr($run,0,3);
		
		echo "$nilai \n";
		
		$panjang_silinder= 255;
$radius_elip = 5;
$diameter = 135;
$jari = $diameter/2;
$kedalaman = $diameter-($nilai-10);

$hasil= ($jari*$jari*ACOS(($jari-$kedalaman)/$jari)-(($jari-$kedalaman)*(sqrt((2*$jari*$kedalaman)-($kedalaman*$kedalaman)))))*$panjang_silinder+(22/7*$radius_elip*(3*$jari-$kedalaman)*$kedalaman*$kedalaman/3/$jari);
$hasil = $hasil/1000;
$hasil = round($hasil);
$nilai=$hasil;

echo $hasil;
		//$nilai=20;	

		
		$sql1 = $konek->query("SELECT NILAIMIN,NILAIMAX,NAMALOKASI,POSISIDETAIL,PARAMETER FROM sensor WHERE ID_SENSOR='$id'");
			$cek=$sql1->fetch_assoc();
			$min = $cek['NILAIMIN'];
			$max = $cek['NILAIMAX'];
			$lok = $cek['NAMALOKASI'];
			$pos = $cek['POSISIDETAIL'];
			$par = $cek['PARAMETER'];
			$nilai = trim($nilai);	
			if(($nilai<$min) || ($nilai>$max)){
			if($par!="Gas"){
			if($par!="Arus"){
				$pesan="";
		//$pesan ="Alarm di $lok -> $par $pos !! ";
			}else{
			$pesan="";
		}
		}
		}else{
			$pesan="";
		}
	
		if($cek2=="UNI"){
			$koneksi = "Y";
	
	
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ($id,NOW(),'$nilai','$pesan','$koneksi')");
	
}
	echo "$len -- $ip $nilai $cek2 $run \n";
		
  
	//mysql_query("INSERT INTO trans5()");

	//echo " $id <br> $opt <br> $ip <br> $var <br><br>";
 }
 //echo "DONE!";
?>
