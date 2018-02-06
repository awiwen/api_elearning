<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");
 
 
if(isset($_GET["id_gunung"])&& isset($_GET["nama"])&& isset($_GET["kabupaten"])&& isset($_GET["latpuncak"])&& isset($_GET["lonpuncak"])&& isset($_GET["latpos"])&& isset($_GET["lonpos"])&& isset($_GET["deskripsi"])&& isset($_GET["ketinggian"])&& isset($_GET["flora"]) && isset($_GET["fauna"]) ){
	if(!empty($_GET["id_gunung"])&& !empty($_GET["nama"])&& !empty($_GET["kabupaten"])&& !empty($_GET["latpuncak"])&& !empty($_GET["lonpuncak"])&& !empty($_GET["latpos"])&& !empty($_GET["lonpos"])&& !empty($_GET["deskripsi"])&& !empty($_GET["ketinggian"])&& !empty($_GET["flora"])&& !empty($_GET["fauna"]) ){
	
		$conn = new mysqli("localhost", "root", "", "gunung");
		
		$id_gunung=$_GET["id_gunung"];
		$nama=$_GET["nama"];
		$kabupaten=$_GET["kabupaten"];
		$latpuncak=$_GET["latpuncak"];
		$lonpuncak=$_GET["lonpuncak"];
		$latpos=$_GET["latpos"];
		$lonpos=$_GET["lonpos"];
		$deskripsi=$_GET["deskripsi"];
		$ketinggian=$_GET["ketinggian"];
		$flora=$_GET["flora"];
		$fauna=$_GET["fauna"];
		

		$sql="update tb_gunung 
		set Nama = '".$nama."',
			Kabupaten = '".$kabupaten."',
			lat_puncak = '".$latpuncak."',
			lon_puncak = '".$lonpuncak."',
			lat_pos = '".$latpos."',
			lon_pos = '".$lonpos."',
			Deskripsi = '".$deskripsi."',
			Ketinggian = '".$ketinggian."',
			Flora = '".$flora."',
			Fauna = '".$fauna."'
			where id_gunung = '".$id_gunung."'
			";
		if($conn->query($sql) === TRUE) {
			echo true;
		}
	}
}

 
?>