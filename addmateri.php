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

if(!empty($_POST["judul"])&& !empty($_POST["konten"])&& !empty($_POST["tgl_posting"])&&
    !empty($_POST["mapel_id"])&& !empty($_POST["pengajar_id"])&&
     !empty($_POST["kelas_id"]) ){

			$judul=$_POST["judul"];
			$konten=$_POST["konten"];
			$raw_tgl_posting = $_POST["tgl_posting"];
      $tgl_posting= strstr($raw_tgl_posting, " (", true);
			$mapel_id=$_POST["mapel_id"];
			$pengajar_id=$_POST["pengajar_id"];
			$kelas_id=$_POST["kelas_id"];

	// $ext1 = pathinfo($_FILES['image1']['name'],PATHINFO_EXTENSION);
	// $ext2 = pathinfo($_FILES['image2']['name'],PATHINFO_EXTENSION);
	// $ext3 = pathinfo($_FILES['image3']['name'],PATHINFO_EXTENSION);
	// $image1 = time().date("dmY").'1'.'.'.$ext1;
	// $image2 = time().date("dmY").'2'.'.'.$ext2;
	// $image3 = time().date("dmY").'3'.'.'.$ext3;
  //
	// move_uploaded_file($_FILES["image1"]["tmp_name"], "C:\\xampp\\htdocs\\agrowisata\\uploads\\".$image1);
	// move_uploaded_file($_FILES["image2"]["tmp_name"], "C:\\xampp\\htdocs\\agrowisata\\uploads\\".$image2);
	// move_uploaded_file($_FILES["image3"]["tmp_name"], "C:\\xampp\\htdocs\\agrowisata\\uploads\\".$image3);

	$sqlmateri="insert into materi(judul, konten, tgl_posting, mapel_id, pengajar_id, kelas_id)
		  values('$judul', '$konten', now(), '$mapel_id', '$pengajar_id', '$kelas_id')";


	if(mysqli_query($conn,$sqlmateri))
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
