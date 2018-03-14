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

        $pengajar_id=$_GET["pengajar_id"];

        $query = mysqli_query($conn, "SELECT * FROM `mapel_ajar`
    																	LEFT JOIN `mapel_kelas` ON `mapel_kelas`.`id` = `mapel_ajar`.`mapel_kelas_id`
    																	LEFT JOIN `mapel` ON `mapel`.`mapel_id` = `mapel_kelas`.`mapel_id`
    																	LEFT JOIN `kelas` ON `mapel_kelas`.`kelas_id` = `kelas`.`kelas_id`
    																	LEFT JOIN `pengajar` ON `pengajar`.`pengajar_id` = `mapel_ajar`.`pengajar_id`
    																	LEFT JOIN `hari` ON `mapel_ajar`.`hari_id` = `hari`.`hari_id`
    																	where `pengajar`.pengajar_id = '".$pengajar_id."' group by mapel.mapel_id ");

        $myarr = array();
        if($query){
            while($data = $query->fetch_array(MYSQLI_ASSOC)){
                $myarr[] = $data;
            } echo json_encode($myarr);
}
?>
