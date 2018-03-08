<?php 

	include "cronpac.php";
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

		$nilai = substr($run,-4);
		$nilai = $nilai /10;
		
		$cek2 = substr($run,0,3);
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
		$pesan ="Alarm di $lok -> $par $pos !! ";
			}else{
			$pesan="";
		}
		}
		}else{
			$pesan="";
		}
	
		if($cek2=="SNM"){
			$koneksi = "Y";
	
	
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ($id,NOW(),'$nilai','$pesan','$koneksi')");
	
}
	echo "$len -- $ip $nilai $cek2 $run \n";
		
  
	//mysql_query("INSERT INTO trans5()");

	//echo " $id <br> $opt <br> $ip <br> $var <br><br>";
 }
 //echo "DONE!";
?>
