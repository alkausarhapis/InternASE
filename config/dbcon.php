<?php
$servername = "localhost"; // atau bisa disesuaikan
$username = "root"; // username default XAMPP
$password = ""; // password default XAMPP
$dbname = "database_labmanagement"; // ganti dengan nama database Anda

// Membuat koneksi
$conn = mysqli_connect( $servername, $username, $password, $dbname );

// Cek koneksi
if ( !$conn ) {
    die( "Connection failed: " . mysqli_connect_error() );
}