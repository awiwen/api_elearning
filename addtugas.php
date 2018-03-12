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

if(!empty($_POST["judul"])&& !empty($_POST["konten"]) && !empty($_POST["tgl_buat"])&&
    !empty($_POST["th_selesai"])&&
		!empty($_POST["b_selesai"])&&!empty($_POST["t_selesai"])&&!empty($_POST["mapel_id"])&& !empty($_POST["pengajar_id"])&&
     !empty($_POST["kelas_id"]) ){

			$judul=$_POST["judul"];
			$konten=$_POST["konten"];
			$raw_tgl_buat = $_POST["tgl_buat"];
		 	$tgl_buat= strstr($raw_tgl_buat, " (", true);
      $tgl_selesai=$_POST["th_selesai"].'-'.$_POST["b_selesai"].'-'.$_POST["t_selesai"];
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
          move_uploaded_file($_FILES["file"]["tmp_name"], "C:\\xampp\\htdocs\\elearning-smip\\assets\\filetugas\\".$file);
        }
      }

      if ($uploadSize<1) {

    if (date("Y-m-d") < $tgl_selesai) {

	$sqltugas="insert into tugas(judul, konten, tgl_buat, tgl_selesai, mapel_id, pengajar_id, kelas_id, file)
		  values('$judul', '$konten', now(), '$tgl_selesai', '$mapel_id', '$pengajar_id', '$kelas_id', '$file')";

  // $kelas_id=$_GET["kelas_id"];

  $query = mysqli_query($conn, "SELECT * from siswa
                                LEFT JOIN `login` ON `siswa`.`siswa_id` = `login`.`siswa_id`
                                where `siswa`.kelas_id = '".$kelas_id."'
                                ");




    	if($queryTugas = mysqli_query($conn,$sqltugas))
    	{
        $tugas_id = mysqli_insert_id($conn);
        $myarr = array();


        while($data = mysqli_fetch_assoc($query)){

          // print_r($data);
            // $my1arr[] = $data;
            $judul=$_POST["judul"];
      			$konten=$_POST["konten"];
      			$raw_tgl_buat = $_POST["tgl_buat"];
      		 	$tgl_buat= strstr($raw_tgl_buat, " (", true);
            $tgl_selesai=$_POST["th_selesai"].'-'.$_POST["b_selesai"].'-'.$_POST["t_selesai"];
      			$mapel_id=$_POST["mapel_id"];
      			$pengajar_id=$_POST["pengajar_id"];
      			$kelas_id=$_POST["kelas_id"];
            $file= '';
            $uploadSize = 0;

            $login_id = $data["login_id"];;

            $sqlnotif=" insert into notifikasi(pesan, tgl, oleh, login_id, status_id, tugas_id, link)
          		                         values('tugas', '$tgl_selesai', '$judul', '$login_id', '1', '$tugas_id', 'http://localhost/elearning-smip/index.php/cdetailtugas/showdetailtugas/$tugas_id') ";

            $notif = mysqli_query($conn,$sqlnotif);


        }

    		echo "Tambah tugas sukses";
    	}

    	else
    	{
    		echo "Uploading files error";
    	}

    }
    else
    {
    echo "tanggal tidak sesuai";
    }
  }
}

else
{
echo "File is empty";
}


?>
