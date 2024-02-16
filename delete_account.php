<?php
require_once 'database/db_connection.php';
session_start();


// Ustawienie user_id (zakładam, że jest przekazywane jako POST parametr)
$user_id = $_SESSION['id'];

// Dodaj to: "DELETE FROM users WHERE user_id = :user_id"
$deleteStmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
$deleteStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

// Uruchom zapytanie usuwające
$deleteStmt->execute();
unset($_SESSION['id']);
exit();
