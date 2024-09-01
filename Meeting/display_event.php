<?php
include 'config.php';

$display_query = "SELECT agenda_id, nama_agenda, waktu_agenda, jenis_agenda, deskripsi FROM agenda";
$results = mysqli_query($conn, $display_query);
$count = mysqli_num_rows($results);

if ($count > 0) {
    $data_arr = array();
    $i = 1;
    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $data_arr[$i]['agenda_id'] = $data_row['agenda_id'];
        $data_arr[$i]['title'] = $data_row['nama_agenda'];
        $data_arr[$i]['start'] = date("Y-m-d H:i:s", strtotime($data_row['waktu_agenda']));
        $data_arr[$i]['jenis_agenda'] = $data_row['jenis_agenda'];
        $data_arr[$i]['deskripsi'] = $data_row['deskripsi'];
        $data_arr[$i]['color'] = '#'.substr(uniqid(), -6);
        $i++;
    }

    $data = array(
        'status' => true,
        'msg' => 'Wenak',
        'data' => $data_arr
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Gagal.'
    );
}
echo json_encode($data);
?>
