<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $conn->query('SELECT * FROM meeting');
    $meetings = [];

    while ($row = $result->fetch_assoc()) {
        $meetings[] = $row;
    }
    
    echo json_encode($meetings);
}
?>
