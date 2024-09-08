<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $deskripsi = $_POST['deskripsi'];

    if (empty($judul) || empty($penulis) || empty($deskripsi)) {
        echo json_encode(["error" => "Need 3 input"]);
    } else {
        $stmt = $conn->prepare("INSERT INTO dokumen (judul, penulis, deskripsi) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $judul, $penulis, $deskripsi);

        if ($stmt->execute()) {
            echo json_encode(["success" => "wenak"]);
        } else {
            echo json_encode(["error" => "Failed"]);
        }
        $stmt->close();
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
