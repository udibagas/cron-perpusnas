<?php

	include_once "koneksi.php";
    $query = $konek->query("SELECT * FROM sensor WHERE PRODUCT LIKE '%unitron%'");

    $vars = [
        'Suhu'      => 'bacaSuhu',
        'Lembab'    => 'bacaLembab',
        'Gas'       => 'bacaGas',
        'Arus'      => 'bacaArus',
        'Jarak'     => 'bacaJarak',
    ];

    while (true)
    {
        while ($data = $query->fetch_assoc())
        {
            $id       = $data['ID_SENSOR'];
            $var      = $vars[$data['PARAMETER']];
            $ip_addr  = $data['IPADDR'];
            $shell    = "/usr/bin/snmpget -v 1 -c public $ip_addr $var 2>&1";

            echo $shell."\n";

    		$run      = shell_exec($shell);
    		$len      = strlen($run);

    		if ($var=="bacaArus")
            {
    			if (strlen($run)==33) {
    				$nilai = substr($run,-4);
    			} elseif (strlen($run)==34) {
    				$nilai = substr($run,-5);
    			} elseif (strlen($run)==35) {
    				$nilai = substr($run,-6);
    			} else {
    				$nilai = substr($run,-3);
    			}
    		}

            else {
    		    $nilai = substr($run,-3);
    		}

    		$cek2 = substr($run,0,3);

            $sql = $konek->query("SELECT NILAIMIN,NILAIMAX,NAMALOKASI,POSISIDETAIL,PARAMETER FROM sensor WHERE ID_SENSOR='$id'");
            $cek = $sql->fetch_assoc();
            $min = $cek['NILAIMIN'];
            $max = $cek['NILAIMAX'];
            $lok = $cek['NAMALOKASI'];
            $pos = $cek['POSISIDETAIL'];
            $par = $cek['PARAMETER'];
            $nilai = trim($nilai);

            if (($nilai<$min) || ($nilai>$max)) {
                if($par!="Gas") {
                    if($par!="Arus") {
                        $pesan ="Alarm di $lok -> $par $pos !! ";
                    } else {
                        $pesan="";
                    }
                }
            }

            else{
                $pesan="";
            }

            if($cek2=="UNI"){
                $koneksi = "Y";
                $konek->query("INSERT INTO trans5(ID_SENSOR,tgljam,nilai,pesan,koneksi) VALUES ($id,NOW(),'$nilai','$pesan','$koneksi')");
            }

            echo "$len -- $ip_addr $nilai $cek2 $run \n";
        }

        sleep(5);
    }

?>
