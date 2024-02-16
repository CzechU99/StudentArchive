<?php

$sciezka = $_GET['sciezka'] ?? '';

if ($sciezka !== '') {

    $nazwaPliku = $_FILES['plik']['name'];
    $tempPlik = $_FILES['plik']['tmp_name'];
    $celowaSciezka = $sciezka . '/' . $nazwaPliku;

    move_uploaded_file($tempPlik, $celowaSciezka);
    
    session_start();
    $opis = $_POST['opis'] ?? '';
    $sciezkaOpisow = 'tagdesc/' . $_SESSION['id'];

    if (!file_exists($sciezkaOpisow)) {
        if (!mkdir($sciezkaOpisow, 0777, true)) {
            die('Nie można utworzyć ścieżki...');
        } else {
            echo 'Ścieżka została utworzona pomyślnie!';
        }
    } else {
        echo 'Ścieżka już istnieje.';
    }

    $sciezkaOpisuPlikow =  $sciezkaOpisow . '/' . $nazwaPliku . '_opis.txt';
    if (!empty($opis)) {
        file_put_contents($sciezkaOpisuPlikow, $opis);
    }

    echo "Plik został przesłany pomyślnie!";
}
?>