<?php
include 'config.php';

// Menentukan header untuk JSON output
header('Content-Type: application/json');

// Query untuk mengambil data event
$display_query = "SELECT agenda_id, nama_agenda, waktu_agenda, jenis_agenda, deskripsi FROM agenda";
$results = mysqli_query($conn, $display_query);

// Memeriksa apakah query mengembalikan hasil
if ($results && mysqli_num_rows($results) > 0) {
    $data_arr = array();

    // Mengambil setiap baris hasil dari query
    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $data_arr[] = array(
            'event_id' => $data_row['agenda_id'],
            'title' => $data_row['nama_agenda'],
            'start' => date("Y-m-d H:i:s", strtotime($data_row['waktu_agenda'])),
            'jenis_agenda' => $data_row['jenis_agenda'],
            'deskripsi' => $data_row['deskripsi'],
            'color' => '#'.substr(uniqid(), -6) // Warna acak untuk setiap event
        );
    }

    // Mengemas data dalam format JSON
    $data = array(
        'status' => true,
        'msg' => 'Data berhasil diambil.',
        'data' => $data_arr
    );
} else {
    // Mengembalikan pesan error jika tidak ada data yang ditemukan
    $data = array(
        'status' => false,
        'msg' => 'Tidak ada data yang ditemukan.'
    );
}

// Mengembalikan data dalam format JSON
echo json_encode($data);
?>
