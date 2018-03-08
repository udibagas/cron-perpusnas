<?php 

	include "cronups.php";
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
  $shell = "/usr/bin/snmpget $opt -m UPS-MIB $ip $var 2>&1";

		
		
		$run = shell_exec($shell);
		$len = strlen($run);
		$var1 = substr($var,0,14);
				if($var1=="upsBatteryStat"){			
					$nilai = substr($run,-3,1);
				}elseif($var1=="upsBatteryVolt"){			
					$nilai = substr($run,-17,5);
					$nilai = $nilai/10;
				}elseif($var1=="upsBatteryTemp"){			
					$nilai = substr($run,-23,3);
				}elseif($var1=="upsOutputPerce"){			
					$nilai = substr($run,-11,3);
				}elseif($var1=="upsOutputVolta"){			
					$nilai = substr($run,-14,4);
				}elseif($var1=="upsOutputFrequ"){			
					$nilai = substr($run,-14,4);
					$nilai =$nilai/10;
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
			}else{
			$pesan="";
		}
		
		
		if($cek2=="UPS"){
			$koneksi = "Y";
	
	
		$konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ($id,NOW(),'$nilai','$pesan','$koneksi')");
	
}
	echo "$len $id -- $ip $nilai $cek2 $run \n";
		
  
	//mysql_query("INSERT INTO trans5()");

	//echo " $id <br> $opt <br> $ip <br> $var <br><br>";
 }
 //echo "DONE!";
?>
