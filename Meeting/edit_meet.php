<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_meeting']) && !empty($_POST['id_meeting'])) {
        $id_meeting = $_POST['id_meeting'];

        $fields = [];
        $params = [];
        $types = '';

        if (isset($_POST['title'])) {
            $fields[] = 'title = ?';
            $params[] = $_POST['title'];
            $types .= 's';
        }
        if (isset($_POST['speaker'])) {
            $fields[] = 'speaker = ?';
            $params[] = $_POST['speaker'];
            $types .= 's';
        }
        if (isset($_POST['date'])) {
            $fields[] = 'date = ?';
            $params[] = $_POST['date'];
            $types .= 's';
        }
        if (isset($_POST['start_time'])) {
            $fields[] = 'start_time = ?';
            $params[] = $_POST['start_time'];
            $types .= 's';
        }
        if (isset($_POST['end_time'])) {
            $fields[] = 'end_time = ?';
            $params[] = $_POST['end_time'];
            $types .= 's';
        }
        if (isset($_POST['meeting_link'])) {
            $fields[] = 'meeting_link = ?';
            $params[] = $_POST['meeting_link'];
            $types .= 's';
        }
        if (isset($_POST['description'])) {
            $fields[] = 'description = ?';
            $params[] = $_POST['description'];
            $types .= 's';
        }

        if (!empty($fields)) {

            $sql = 'UPDATE meeting SET ' . implode(', ', $fields) . ' WHERE id_meeting = ?';
            $params[] = $id_meeting;
            $types .= 'i';

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param($types, ...$params);
                if ($stmt->execute()) {
                    echo json_encode(['message' => 'Meeting updated successfully']);
                } else {
                    echo json_encode(['error' => 'Error updating meeting: ' . $stmt->error]);
                }
                $stmt->close();
            } else {
                echo json_encode(['error' => 'Failed to prepare the statement: ' . $conn->error]);
            }
        } else {
            echo json_encode(['error' => 'No fields to update']);
        }
    } else {
        echo json_encode(['error' => 'Meeting ID is required']);
    }
}

$conn->close();
?>
