<?php
$host = 'localhost';
$dbname = 'student_archive';
$username = 'root';
$password = '';

try {
// Tworzenie połączenia
$db_connection = new mysqli($host, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($db_connection->connect_error) {
    die("Connection failed: " . $db_connection->connect_error);
}

// Ustawienie kodowania
$db_connection->set_charset("utf8");

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}
?>