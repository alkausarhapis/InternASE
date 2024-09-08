<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['query'])) {   
    
    $query = $_GET['query'];
    $sql = "SELECT * FROM dokumen WHERE judul LIKE ?";
    $stmt = $conn->prepare($sql);
    $like_query = '%' . $query . '%';
    $stmt->bind_param('s', $like_query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $documents = [];
    while ($row = $result->fetch_assoc()) {
        $documents[] = $row;
    }

    echo json_encode($documents);
    $stmt->close();
    $conn->close();
}
?>
