<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    if (isset($_SESSION['id'])) { 
        $userId = $_SESSION['id'];

        $logFolder = 'eventLogs/user_' . $userId;
        $logFileName = 'user_' . $userId . '_logFile.txt';
        $logFolderFile = $logFolder . '/' . $logFileName;

        if (!file_exists($logFolder)) {
            mkdir($logFolder, 0777, true); 
        }

        $logMessage = "Plik: " . $data->fileName . " ||| ";
        $logMessage .= "Data i godzina: " . $data->timestamp . " ||| ";
        $logMessage .= "Zdarzenie: " . $data->type . " ||| "; 
        $logMessage .= "Szczegóły: " . $data->details . "\n";
        $logMessage .= "------------------------------------------------------------------------------------------------------------\n";

        file_put_contents($logFolderFile, $logMessage, FILE_APPEND); 
    }
}
?>