<?php
include 'db.php';

if ( isset( $_POST['id_agenda'] ) ) {
    $id_agenda = $_POST['id_agenda'];

    $sql = "DELETE FROM Agenda WHERE id_agenda='$id_agenda'";
    if ( $conn->query( $sql ) === TRUE ) {
        echo "Event deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>