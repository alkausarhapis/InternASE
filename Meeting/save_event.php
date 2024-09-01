<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$nama_agenda = $_POST['nama_agenda'];
$waktu_agenda = date("Y-m-d H:i:s", strtotime($_POST['waktu_agenda']));
$jenis_agenda = $_POST['jenis_agenda'];
$deskripsi = $_POST['deskripsi'];

$insert_query = "INSERT INTO `agenda` (`nama_agenda`, `waktu_agenda`, `jenis_agenda`, `deskripsi`) VALUES ('".$nama_agenda."', '".$waktu_agenda."', '".$jenis_agenda."', '".$deskripsi."')";

if (mysqli_query($conn, $insert_query)) {
    $data = array(
        'status' => true,
        'msg' => 'Wenak!'
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Gagal.'
    );
    }
echo json_encode($data);
}
?>
