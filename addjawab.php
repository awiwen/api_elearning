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

if(!empty($_POST["siswa_id"]) && !empty($_POST["tugas_id"]) && !empty($_POST["tgl_buat"]) && !empty($_POST["tgl_se"])
    && !empty($_FILES["file"]) && !empty($_POST["konten"])){

			$siswa_id=$_POST["siswa_id"];
      $tugas_id=$_POST["tugas_id"];
			$raw_tgl_buat = $_POST["tgl_buat"];
		 	$tgl_buat= strstr($raw_tgl_buat, " (", true);
      $tgl_se=$_POST["tgl_se"];
			$konten=$_POST["konten"];

    $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    $file = $siswa_id.date("dmY").'.'.$ext;

    move_uploaded_file($_FILES["file"]["tmp_name"], "C:\\xampp\\htdocs\\elearning-smip\\assets\\filejawaban\\".$file);

	$sqljawab="insert into tugas_jawaban(siswa_id, tugas_id, tgl_buat , file , konten)
		  values('$siswa_id', '$tugas_id', now() , '$file' , '$konten')";


	if(mysqli_query($conn,$sqljawab))
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
