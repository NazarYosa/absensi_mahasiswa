<?php

$dbHost = 'localhost';
$dbName = 'absensi';
$dbUsername = 'absensi';
$dbPassword = '';

$mysqli = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

if (!$mysqli) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
