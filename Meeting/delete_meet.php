<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_meeting = $_POST['id_meeting'];

    $stmt = $conn->prepare('DELETE FROM meeting WHERE id_meeting = ?');
    $stmt->bind_param('i', $id_meeting);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Meeting deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting meeting']);
    }

    $stmt->close();
}
?>
