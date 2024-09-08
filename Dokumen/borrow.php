<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $doc_id = $_POST['doc_id'];
    $borrower = $_SESSION['id_user'] = 1; // Static user ID for testing
    $return_time = date('Y-m-d H:i:s', strtotime('+7 days'));

    // Get borrower's username
    $sql = "SELECT username FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $borrower); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $borrower_name = $row['username'];

    // Update document borrow status
    $sql = "UPDATE borrow SET status='borrowed', id_user=?, return_time=? WHERE doc_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $borrower, $return_time, $doc_id); 
    if ($stmt->execute()) {
        // Proper JSON response for success
        echo json_encode([
            'message' => 'Success',
            'borrower_name' => $borrower_name
        ]);
    } else {
        // Proper JSON response for failure
        echo json_encode([
            'message' => 'Error updating borrow status'
        ]);
    }
    $stmt->close();
}
