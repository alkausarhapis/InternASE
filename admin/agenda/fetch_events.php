<?php
include 'db.php';

$sql = "SELECT * FROM Agenda";
$result = $conn->query( $sql );

$events = array();

while ( $row = $result->fetch_assoc() ) {
    $event = array(
        'id' => $row['id_agenda'],
        'title' => $row['agenda_name'],
        'start' => $row['date'],
        'type' => $row['type'],
        'desc' => $row['description'],
    );
    array_push( $events, $event );
}

echo json_encode( $events );
?>