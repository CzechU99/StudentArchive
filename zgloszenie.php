<?php

session_start();
//$_SESSION['id']

require_once 'database/db_connection.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $elementName = isset($_POST['elementName']) ? $_POST['elementName'] : '';
  $elementPath = isset($_POST['elementPath']) ? $_POST['elementPath'] : '';
  $elementOwner = isset($_POST['elementOwner']) ? $_POST['elementOwner'] : '';
  $komentarz = isset($_POST['komentarz']) ? $_POST['komentarz'] : '';


  $insertQuery = "INSERT INTO zgloszenia (zgloszenia.plik, zgloszenia.sciezka, zgloszenia.id_wlascicela, zgloszenia.id_zglaszajacego, zgloszenia.wiadomosc) VALUES (:plik, :sciezka, :id1, :id2, :wiadomosc)";
                    $insertStmt = $pdo->prepare($insertQuery);
                    $insertStmt->bindParam(':plik', $elementName);
                    $insertStmt->bindParam(':sciezka', $elementPath);
                    $insertStmt->bindParam(':id1', $elementOwner);
                    $insertStmt->bindParam(':id2', $_SESSION['id']);
                    $insertStmt->bindParam(':wiadomosc', $komentarz);
                    if ($insertStmt->execute())
                    {
                      header("Location: serched_user.php?userId=$elementOwner&status=Zgloszenie");
                    }
}

?>