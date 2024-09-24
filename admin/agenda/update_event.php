<?php
include 'db.php';

if ( isset( $_POST['id_agenda'], $_POST['agenda_name'], $_POST['date'], $_POST['type'], $_POST['desc'] ) ) {
    $id_agenda = $_POST['id_agenda'];
    $agenda_name = $_POST['agenda_name'];
    $date = $_POST['date'];
    $type = $_POST['type'];
    $desc = $_POST['desc'];

    $sql = "UPDATE Agenda SET agenda_name='$agenda_name', date='$date', type='$type', `desc`='$desc' WHERE id_agenda='$id_agenda'";
    if ( $conn->query( $sql ) === TRUE ) {
        echo "Event updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: Incomplete data";
}

$conn->close();
?>