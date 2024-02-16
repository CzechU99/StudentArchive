<?php

if (isset($_POST['usun'])) {
    $sciezka = $_POST['sciezka'];
    $plikId = $_POST['plik_id'];

    // Usuwanie pliku
    if (file_exists($sciezka)) {
        unlink($sciezka);
        echo "Plik został usunięty.<br>";
    } else {
        echo "Plik nie istnieje lub nie można go usunąć.<br>";
    }

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
