<html>
<head>
<title>UNITRON</title>
<link rel="stylesheet" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link rel="stylesheet" href="jqueryui/jquery-ui.min.css" />
</head>
<body bgcolor="black" topmargin="0" marginwidth="0" marginheight="0">

<table align="center" bgcolor="#051a2a"  width="1920" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td bgcolor="#30375c" colspan="2">
	<!-- Menunya yang di atas Mulai -->
		<div class="menu-wrap">
		<ul>
		<?php 
		set_time_limit(0);
		session_start();
		
		if($_SESSION['user']<>null){
		
		?>
			
			<li ><a href="?page=home">Ikhtisar</a></li>
			<li><a href="?page=histori_alert">Rekaman</a></li>
			<li><a href="?page=tren">Lingkungan</a></li>
			<li><a href="?page=listrik">Kelistrikan</a></li>
			<li><a href="?page=PUE">Efisiensi</a></li>
			<li><a href="?page=buku_tamu">Buku Tamu</a></li>
			<!-- <li><a href="?page=efisiensi">Efisiensi</a></li> -->
			<li><a href="?page=inventori">Inventori</a></li>
			
			
			<li ><a href="logout.php">Logout</a></li>
			
		<?php } 
		?>
		
		</ul>    
	</div>
<!-- Menunya yang di atas Selesai -->
        </td>
		
	<td bgcolor="#30375c">
			<img src="images/kepala_02.png" width="320" height="118" alt="">
	</td>
	</tr>

	<tr height="20"> 
	<td colspan="2" width="44">	</td>
	<td valign="top" bgcolor="#30375c" width="44" rowspan=4><img src="images/kepala_04.png" width="320" height="374"></td>
	</tr>

	<td  colspan="2" width="44">	</td>
	</tr>
    <tr>
		<td width="44"></td>
		<td valign="top" width="1600"><?php include "isi.php"; ?></td>
		<td rowspan="6" bgcolor="#30375c"></td>    
	</tr>
		
	<tr height="20"> 
	<td bgcolor="#fff" colspan="2" width="44">	</td>
	</tr>
	
	<tr>
		<td colspan="2" width="1600" height="50" bgcolor="#30375c" align="center" ><font face="Verdana, Geneva, sans-serif" color="#FFFFFF">Copyright 2015</font></td>
		<td width="320" height="50" bgcolor="#30375c"></td>
	</tr>
	
	
</table>
<!-- End ImageReady Slices -->
</body>
</html>
