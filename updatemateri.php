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


if(!empty($_POST["materi_id"])&& !empty($_POST["judul"])&& !empty($_POST["konten"]) &&
    !empty($_POST["mapel_id"])&& !empty($_POST["pengajar_id"])&& !empty($_POST["kelas_id"]) ){

			$materi_id=$_POST["materi_id"];
			$judul=$_POST["judul"];
			$konten=$_POST["konten"];
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

			$sqlmateri="update materi
			set
				judul = '".$judul."',
				konten = '".$konten."',
				mapel_id = '".$mapel_id."',
				pengajar_id = '".$pengajar_id."',
				kelas_id = '".$kelas_id."',
				file = '".$file."'
				where materi_id = '".$materi_id."'
				";
			if($conn->query($sqlmateri) === TRUE) {
				echo "Edit berhasil";
			}
		}
	// }


// 	$sqlmateri="update materi set(judul, konten, tgl_posting, tgl_selesai, mapel_id, pengajar_id, kelas_id, file)
// 		  values('$judul', '$konten', now(), '$tgl_selesai', '$mapel_id', '$pengajar_id', '$kelas_id', '$file')";
//
//
//     	if(mysqli_query($conn,$sqlmateri))
//     	{
//     		echo "Files are uploaded, your recomendation will be shown if it validated";
    	// }
    // }
    // else
    // {
    // echo "tanggal tidak sesuai";
    // }

}
else
{
echo "File is empty";
}
// }



?>
