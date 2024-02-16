<?php
require_once 'database/db_connection.php';
session_start();



$user_id = $_SESSION['id'];

// Dodaj to: "UPDATE users SET archived_account = 1 WHERE user_id = :user_id"
$stmt = $pdo->prepare("UPDATE users SET is_account_archived = 1 WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

// Uruchom zapytanie
$stmt->execute();
unset($_SESSION['id']);
header('Location: log_rej.php');
exit();
