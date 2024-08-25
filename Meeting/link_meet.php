<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_meeting = $_GET['id_meeting'];

    $stmt = $conn->prepare('SELECT meeting_link FROM meeting WHERE id_meeting = ?');
    $stmt->bind_param('i', $id_meeting);
    $stmt->execute();
    $stmt->bind_result($meeting_link);
    $stmt->fetch();

    echo json_encode(['meeting_link' => $meeting_link]);

    $stmt->close();
}
?>
