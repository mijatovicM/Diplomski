<?php

$DB_HOSTNAME = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "";
$DB_DATABASE = "izvestavaj";

//PDO Setup

$dsn = "mysql:host=$DB_HOSTNAME;dbname=$DB_DATABASE";
$pdo = new PDO($dsn, $DB_USERNAME, $DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
?>

