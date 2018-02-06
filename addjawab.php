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

if(!empty($_POST["siswa_id"])&& !empty($_POST["tugas_id"])&& !empty($_POST["tgl_buat"])&&
     !empty($_POST["tgl_se"])&& !empty($_POST["konten"])){

			$siswa_id=$_POST["siswa_id"];
			$tugas_id=$_POST["tugas_id"];
			$tgl_buat = $_POST["tgl_buat"];
			$tgl_selesai = $_POST["tgl_se"];
			$konten = $_POST["konten"];

      if ($tgl_buat <= $tgl_selesai) {

	      $sqljawab="insert into tugas_jawaban(siswa_id, tugas_id, tgl_buat, konten)
  		  values('$siswa_id', '$tugas_id', now(), '$konten')";

        if(mysqli_query($conn,$sqljawab))
      	{
      		echo "tambah jawaban sukses";
      	}
      	else
      	{
      		echo "Uploading files error";
      	}

    } else {
            echo "Waktu menjawab sudah habis!!!!";
          }
        }
        else
        {
        echo "File is empty";
        }
      // }
?>
