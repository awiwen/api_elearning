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

        $query = mysqli_query($conn, "SELECT `pengajar_id`, `nuptk`, `nama`, `jenis_kelamin`, `tempat_lahir`,
                                    	DATE_FORMAT(tgl_lahir, '%d %M %Y') AS tgl_l,
                                    	`alamat`,`status_kg`,`pend_terakhir`,`b_studi`,`tahun_masuk`, `status_nama`,
                                    	(YEAR(CURDATE())-YEAR(tahun_masuk)) AS `masa_kerja` FROM `pengajar`
                                    	RIGHT JOIN `status` ON `pengajar`.`status_id` = `status`.`status_id`");

        $myarr = array();
        if($query){
            while($data = $query->fetch_array(MYSQLI_ASSOC)){
                $myarr[] = $data;
            } echo json_encode($myarr);
}
?>
