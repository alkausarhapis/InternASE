<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include 'config.php';

    $sql = "SELECT * FROM dokumen";
    $result = $conn->query($sql);

    $documents = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $documents[] = $row;
        }
    }

    echo json_encode($documents);
}

?>