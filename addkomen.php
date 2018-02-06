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

if(!empty($_POST["materi_id"])&& !empty($_POST["login_id"])&& !empty($_POST["tgl_posting"])&& !empty($_POST["konten"])){

			$materi_id=$_POST["materi_id"];
			$login_id=$_POST["login_id"];
			$tgl_posting = $_POST["tgl_posting"];
			$konten=$_POST["konten"];

	$sqlkomen="insert into komentar_materi(materi_id, login_id, tgl_posting, konten)
		  values('$materi_id', '$login_id', now(), '$konten')";


	if(mysqli_query($conn,$sqlkomen))
	{
		echo "posting komentar sukse";
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
