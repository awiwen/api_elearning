<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");


if(isset($_GET["tugas_id"])&& isset($_GET["judul"])&& isset($_GET["konten"])&& isset($_GET["tgl_bu"])&& isset($_GET["tgl_se"])&& isset($_GET["mapel_id"])&& isset($_GET["pengajar_id"])&& isset($_GET["kelas_id"]) ){
	if(!empty($_GET["tugas_id"])&& !empty($_GET["judul"])&& !empty($_GET["konten"])&& !empty($_GET["tgl_bu"])&& !empty($_GET["tgl_se"])&& !empty($_GET["mapel_id"])&& !empty($_GET["pengajar_id"])&& !empty($_GET["kelas_id"]) ){

		$conn = new mysqli("localhost", "root", "", "new_elearning");
		
		$tugas_id=$_GET["tugas_id"];
		$judul=$_GET["judul"];
		$konten=$_GET["konten"];
		$tgl_buat=$_GET["tgl_bu"];
		$tgl_selesai=$_GET["tgl_se"];
		$mapel_id=$_GET["mapel_id"];
		$pengajar_id=$_GET["pengajar_id"];
		$kelas_id=$_GET["kelas_id"];

		$sql="update tugas
		set judul = '".$judul."',
			konten = '".$konten."',
			tgl_buat = '".$tgl_buat."',
			tgl_selesai = '".$tgl_selesai."',
			mapel_id = '".$mapel_id."',
			pengajar_id = '".$pengajar_id."',
			kelas_id = '".$kelas_id."'
			where tugas_id = '".$tugas_id."'
			";
		if($conn->query($sql) === TRUE) {
			echo true;
		}
	}
}


?>
