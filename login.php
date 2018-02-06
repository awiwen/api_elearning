<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


if(isset($_GET["username"]) && isset($_GET["password"]) ){
	if( !empty($_GET["username"])  && !empty($_GET["password"])  ){

		$conn = new mysqli("localhost", "root", "", "new_elearning");


		$username=$_GET["username"];
		$password=$_GET["password"];

    $query = mysqli_query($conn,"select *, siswa.nama as nama_siswa from login
		LEFt join siswa on login.siswa_id = siswa.siswa_id
		LEFT join pengajar on login.pengajar_id = pengajar.pengajar_id
				where login.username like '".$username."' and login.password like '".$password."'");

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
	}
}

?>
