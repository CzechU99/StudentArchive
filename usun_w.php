<?php

if (isset($_POST['usun'])) {
    $plikId = $_POST['plik_id'];

    // Usuwanie wpisu z bazy danych
    require 'database/db_connection.php';

    try {
        $query = $pdo->prepare("DELETE FROM zgloszenia WHERE zgloszenie_id = :plikId");
        $query->bindParam(':plikId', $plikId, PDO::PARAM_INT);
        $query->execute();
        echo "Wpis został usunięty z bazy danych.";
    } catch (PDOException $e) {
        echo "Błąd: " . $e->getMessage();
    }
}
header('Location: admin.php');

?>
