<?php

if (isset($_POST['usun'])) {
    $userId = $_POST['user_id'];


    // Usuwanie wpisu z bazy danych
    require 'database/db_connection.php';

    try {
        $query = $pdo->prepare("DELETE FROM users WHERE user_id = :userId");
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->execute();
        echo "Wpis został usunięty z bazy danych.";
    } catch (PDOException $e) {
        echo "Błąd: " . $e->getMessage();
    }
}
header('Location: admin.php');

?>
