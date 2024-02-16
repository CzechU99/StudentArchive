<?php 

    session_start();

    require 'database/db_connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ocena = $_POST["ocena"];
        $sciezka = $_POST["sciezka"];
        
        $ocena = mysqli_real_escape_string($conn, $ocena);
        
        $sql = "UPDATE files SET ocena = $ocena WHERE id = $id";
        $result = mysqli_query($conn, $sql);
    }

    $conn->close();

?>