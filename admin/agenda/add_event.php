<?php
include 'db.php';

$agenda_name = $_POST['agenda_name'];
$date = $_POST['date'];
$type = $_POST['type'];
$desc = $_POST['desc'];

$sql = "INSERT INTO Agenda VALUES ('', '$agenda_name', '$date', '$type', '$desc')";
if ( $conn->query( $sql ) === TRUE ) {
    echo "New event added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>