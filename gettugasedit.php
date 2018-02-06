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

        $query = mysqli_query($conn, "select `judul`, `konten`, `file`, `nama_mapel`, `nama`, `nama_kelas`,
	                                            DATE_FORMAT(`tgl_selesai`, '%d %m %Y') AS `tgl_seledit`,
                                              DATE_FORMAT(`tgl_buat`, '%d %m %Y') AS `tgl_buedit` FROM `tugas`
	                                             JOIN `mapel` ON `tugas`.`mapel_id` = `mapel`.`mapel_id`
	                                              JOIN `pengajar` ON `tugas`.`pengajar_id` = `pengajar`.`pengajar_id`
	                                               JOIN `tugas_kelas` ON `tugas`.`tugas_id` = `tugas_kelas`.`tugas_id`
	                                                JOIN `kelas` ON `tugas_kelas`.`kelas_id` = `kelas`.`kelas_id`");

        $myarr = array();
        if($query){
            while($data = $query->fetch_array(MYSQLI_ASSOC)){
                $myarr[] = $data;
            } echo json_encode($myarr);
}
?>
