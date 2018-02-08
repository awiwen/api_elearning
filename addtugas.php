<?php
 if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

$conn = new mysqli("localhost", "root", "", "new_elearning");

$data=json_decode(file_get_contents("php://input"));

if(!empty($_POST["judul"])&& !empty($_POST["konten"]) && !empty($_FILES["file"]) && !empty($_POST["tgl_buat"])&&
    !empty($_POST["th_selesai"])&&
		!empty($_POST["b_selesai"])&&!empty($_POST["t_selesai"])&&!empty($_POST["mapel_id"])&& !empty($_POST["pengajar_id"])&&
     !empty($_POST["kelas_id"]) ){

			$judul=$_POST["judul"];
			$konten=$_POST["konten"];
			$raw_tgl_buat = $_POST["tgl_buat"];
			// $raw_tgl_selesai = $_POST["tgl_selesai"];
			//$tgl_buat = date('Ym-d', strtotime($this->input->post['tgl_buat']));
		 	$tgl_buat= strstr($raw_tgl_buat, " (", true);
			// $tgl_selesai= strstr($raw_tgl_selesai, " (", true);
			// $tgl_selesai=$_POST["tgl_selesai"];
      $tgl_selesai=$_POST["th_selesai"].'-'.$_POST["b_selesai"].'-'.$_POST["t_selesai"];
			$mapel_id=$_POST["mapel_id"];
			$pengajar_id=$_POST["pengajar_id"];
			$kelas_id=$_POST["kelas_id"];

    $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    $file = $mapel_id.date("dmY").'.'.$ext;

    move_uploaded_file($_FILES["file"]["tmp_name"], "C:\\xampp\\htdocs\\elearning-smip\\assets\\filetugas\\".$file);

	$sqltugas="insert into tugas(judul, konten, tgl_buat, tgl_selesai, mapel_id, pengajar_id, kelas_id, file)
		  values('$judul', '$konten', now(), '$tgl_selesai', '$mapel_id', '$pengajar_id', '$kelas_id', '$file')";


	if(mysqli_query($conn,$sqltugas))
	{
		echo "Files are uploaded, your recomendation will be shown if it validated";
	}
	else
	{
		echo "Uploading files error";
	}

}
else
{
echo "File is empty";
}

?>
