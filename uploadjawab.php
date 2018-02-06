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

if(!empty($_POST["tugas_jawaban_id"])&&!empty($_FILES["file"]))
{

	$tugas_jawaban_id = $_POST["tugas_jawaban_id"];

	$ext1 = pathinfo($_FILES['jawaban']['name'],PATHINFO_EXTENSION);
  $jawaban = time().date("dmY").'1'.'.'.$ext1;

	move_uploaded_file($_FILES["file1"]["tmp_name"], "C:\\xampp\\htdocs\\api_elearning\\jawaban\\".$jawaban);

  $query = "UPDATE INTO tugas_jawaban (tugas_jawaban_id, jawaban)
              VALUES ('', '$tugas_jawaban_id', '$jawaban')";

	if(mysqli_query($conn,$query))
	{
		echo "Files is uploaded";
	}
	else
	{
		echo "Uploading file error";
	}

}
else
{
echo "File is empty";
}

?>
