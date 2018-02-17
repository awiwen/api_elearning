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

// $data=json_decode(file_get_contents("php://input"));

if(!empty($_POST["judul"])&& !empty($_POST["konten"]) && !empty($_POST["tgl_posting"])&&
    !empty($_POST["mapel_id"])&& !empty($_POST["pengajar_id"])&&
     !empty($_POST["kelas_id"]) ){

			$judul=$_POST["judul"];
			$konten=$_POST["konten"];
			$raw_tgl_posting = $_POST["tgl_posting"];
      $tgl_posting= strstr($raw_tgl_posting, " (", true);
			$mapel_id=$_POST["mapel_id"];
			$pengajar_id=$_POST["pengajar_id"];
			$kelas_id=$_POST["kelas_id"];
      $file= '';
      $uploadSize = 0;

      if (!empty($_FILES['file'])) {
        $data=json_decode(file_get_contents("php://input"));

        $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
        $file = $mapel_id.date("dmY").'.'.$ext;

        if ($_FILES["file"]["size"] < (40000)){
          echo "file terlalu besar maksimal 4Mb";
          $uploadSize = 1;
        }
        else {
          move_uploaded_file($_FILES["file"]["tmp_name"], "C:\\xampp\\htdocs\\elearning-smip\\assets\\filemateri\\".$file);
        }
      }

      if ($uploadSize<1) {

	$sqlmateri="insert into materi(judul, konten, file, tgl_posting, mapel_id, pengajar_id, kelas_id)
		  values('$judul', '$konten', '$file', now(), '$mapel_id', '$pengajar_id', '$kelas_id')";


	if(mysqli_query($conn,$sqlmateri))
	{
		echo "Tambah materi berhasil";
	}
	else
	{
		echo "Uploading files error";
	}
}
}
else
{
echo "File is empty";
}

?>
