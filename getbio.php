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

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
		$conn = new mysqli("localhost", "root", "", "new_elearning");

		$siswa_id=$_GET["siswa_id"];

    $query = mysqli_query($conn," SELECT * , DATE_FORMAT(`siswa`.`tgl_lahir`, '%d %M %Y') AS `tgl_lah`
                                  FROM `siswa`
                                  LEFT JOIN `kelas` ON `siswa`.`kelas_id` = `kelas`.`kelas_id`
                                  LEFT JOIN `status` ON `siswa`.`status_id` = `status`.`status_id`
																	where `siswa`.`siswa_id` = '".$siswa_id."' ");
        $myarr = array();
        if($query){
            while($data = $query->fetch_array(MYSQLI_ASSOC)){
                $myarr[] = $data;
            } echo json_encode($myarr);
          }

		// $query="select login.login_id, login.siswa_id, login.level, siswa.nis, siswa.nama,
		// 		siswa.jenis_kelamin, siswa.tempat_lahir, siswa.tgl_lahir, siswa.agama,
		// 		siswa.alamat, siswa.tahun_masuk from login join siswa on login.siswa_id = siswa.siswa_id
		// 		where login.username like '".$username."' and login.password like '".$password."'";
		// $result = $conn->query($query);
		// $outp = "";
    //
		// if( $rs=$result->fetch_array(MYSQLI_ASSOC)) {
		// 	if ($outp != "") {$outp .= ",";}
		// 	$outp .= '{login_id:"'  . $rs["login_id"] . '",';
		// 	$outp .= 'siswa_id:"'  . $rs["siswa_id"] . '",';
		// 	$outp .= 'level:"'  . $rs["level"] . '",';
		// 	$outp .= 'nis:"'  . $rs["nis"] . '",';
		// 	$outp .= 'nama:"'  . $rs["nama"] . '",';
		// 	$outp .= 'jenis_kelamin:"'  . $rs["jenis_kelamin"] . '",';
		// 	$outp .= 'tempat_lahir:"'  . $rs["tempat_lahir"] . '",';
		// 	$outp .= 'tgl_lahir:"'   . $rs["tgl_lahir"]        . '",';
		// 	$outp .= 'agama:"'   . $rs["agama"]        . '",';
		// 	$outp .= 'alamat:"'   . $rs["alamat"]        . '",';
		// 	$outp .= 'tahun_masuk:"'. $rs["tahun_masuk"]     . '"}';
		// }
		// // $outp ='{"records"'.$outp.'}';
		// $conn->close();
    //
		// echo json_encode($outp);


?>
