<?php 

	include "cronnti.php";
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
  $shell = "/usr/bin/snmpget $opt -m ENVIROMUX5D $ip $var 2>&1";

		
		
		$run = shell_exec($shell);
		$len = strlen($run);
		$cek = substr($var,-1);
		
		   if(($cek % 2)==0){
		
			$nilai = substr($run,-3);
			if(trim($nilai)=='50'){ //cek aktif atau tidak
				$nilai = 0;
			}

		   }else{
			$nilai = substr($run,-4);
			
			$nilai = $nilai/10;
			if(trim($nilai)=='5'){ //cek aktif atau tidak
				$nilai = 0;
			}			   
		   }

		
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
			
		$pesan ="Alarm di $lok -> $par $pos !! ";
			
		echo "in dia \n";
		}else{
			$pesan="";
		}
		

		if($cek2=="ENV"){
			$koneksi = "Y";
	
		if(trim($nilai)!='0'){
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ($id,NOW(),'$nilai','$pesan','$koneksi')");
		
		}else{
			echo "no alram \n";
		}
		
	
}
	
		echo "$len -- $ip $nilai $cek2 $run $pesan ( $min - $nilai - $max ) \n";
  
	//mysql_query("INSERT INTO trans5()");

	//echo " $id <br> $opt <br> $ip <br> $var <br><br>";
 }
 
 $konek->close();
 //echo "DONE!";
?>
