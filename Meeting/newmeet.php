<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $speaker = $_POST['speaker'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $meeting_link = $_POST['meeting_link'];
    $description = $_POST['description'];

    $stmt = $conn->prepare('INSERT INTO meeting (title, speaker, date, start_time, end_time, meeting_link, description) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('sssssss', $title, $speaker, $date, $start_time, $end_time, $meeting_link, $description);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Wenak']);
    } else {
        echo json_encode(['error' => 'Gagal']);
    }

    $stmt->close();
}
?>
