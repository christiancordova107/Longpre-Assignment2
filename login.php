<?php

$host = 'cssrvlab01.utep.edu'; // Change as necessary
$db = 'cjcordova_f22_db'; // Change as necessary
$user = 'cjcordova'; // Change as necessary
$pass = '*utep2022!'; // Change as necessary
$chrs = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$db;charset=$chrs";
$opts =
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

?>