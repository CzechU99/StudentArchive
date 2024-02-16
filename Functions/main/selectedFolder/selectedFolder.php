<?php
session_start();

// Sprawdź, czy dane zostały przesłane metodą POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobierz id diva z danych przesłanych przez JavaScript
    $divId = $_POST['divId'];

    // Zapisz id diva do zmiennej sesji
    $_SESSION['selectedDivId'] = $divId;

    // Możesz dodać dodatkową logikę zapisu w zależności od potrzeb
    // ...

    // Zwróć odpowiedź do JavaScript (można zwrócić cokolwiek, ale tutaj zwracamy pusty ciąg znaków)
    echo '';
}
?>