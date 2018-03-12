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

if(!empty($_POST["siswa_id"]) && !empty($_POST["tugas_id"]) && !empty($_POST["tgl_buat"]) && !empty($_POST["tgl_se"])
     && !empty($_POST["konten"])){

			$siswa_id=$_POST["siswa_id"];
      $tugas_id=$_POST["tugas_id"];
			$raw_tgl_buat = $_POST["tgl_buat"];
		 	$tgl_buat= strstr($raw_tgl_buat, " (", true);
      $tgl_se=$_POST["tgl_se"];
			$konten=$_POST["konten"];
      $file= '';
      $uploadSize = 0;

      if (!empty($_FILES['file'])) {
        $data=json_decode(file_get_contents("php://input"));

        $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
        $file = $tugas_id.date("dmY").'.'.$ext;

        if ($_FILES["file"]["size"] < (40000)){
          echo "file terlalu besar maksimal 4Mb";
          $uploadSize = 1;
        }
        else {
          move_uploaded_file($_FILES["file"]["tmp_name"], "C:\\xampp\\htdocs\\elearning-smip\\assets\\filejawaban\\".$file);
        }
      }

      if ($uploadSize<1) {

  if ( strtotime(date("d M Y")) < strtotime($tgl_se)) {

	$sqljawab="insert into tugas_jawaban(siswa_id, tugas_id, tgl_buat , file , konten)
		  values('$siswa_id', '$tugas_id', now() , '$file' , '$konten')";

  $query = mysqli_query($conn, "SELECT * from tugas
                                LEFT JOIN `pengajar` ON `tugas`.`pengajar_id` = `pengajar`.`pengajar_id`
                                LEFT JOIN `login` ON `pengajar`.`pengajar_id` = `login`.`pengajar_id`
                                where `tugas`.tugas_id = '".$tugas_id."'
                                ");


                                if($queryJawab = mysqli_query($conn,$sqljawab))
                                {
                                  $tugas_jawaban_id = mysqli_insert_id($conn);
                                  $myarr = array();


                                  while($data = mysqli_fetch_assoc($query)){

                                    // print_r($data);
                                      // $my1arr[] = $data;
                                      $siswa_id=$_POST["siswa_id"];
                                      $tugas_id=$_POST["tugas_id"];
                                			$raw_tgl_buat = $_POST["tgl_buat"];
                                		 	$tgl_buat= strstr($raw_tgl_buat, " (", true);
                                      $tgl_se=$_POST["tgl_se"];
                                			$konten=$_POST["konten"];
                                      $file= '';
                                      $uploadSize = 0;

                                      $login_id = $data["login_id"];;

                                      $sqlnotif=" insert into notifikasi(pesan, tgl, oleh, login_id, status_id, tugas_jawaban_id, link)
                                                                 values('Jawaban', now(), '$siswa_id', '$login_id', '1', '$tugas_jawaban_id', 'http://localhost/elearning-smip/index.php/cdetailjawab_s/showdetailjawab/$tugas_jawaban_id') ";

                                      $notif = mysqli_query($conn,$sqlnotif);
                                  }

                          	// if(mysqli_query($conn,$sqljawab))
                          	// {
                          		echo "tambah jawaban berhasil";
                          	 }
                            	else
                            	{
                            		echo "Uploading files error";
                            	}


  }
  else
  {
  echo "waktu habis";
  }

}

}
else
{
echo "File is empty";
}

?>
