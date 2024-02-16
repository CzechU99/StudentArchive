<?php

  session_start();

  require 'database/db_connection.php';

  $in_id = $_POST['in_id'];
  $out_id = $_POST['out_id'];
  $nameFile = $_POST['nameFile'];

  if($_POST['in_id'] != "" && $_POST['out_id'] != "" && $_POST['nameFile'] != ""){

    $file = $_FILES['file'];

    $sql = "INSERT INTO messages (out_msg_id, in_msg_id, msg_text, displayed, file) VALUES (:in_id, :out_id, :nameFile, 0, 1)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':in_id', $in_id);
    $stmt->bindParam(':out_id', $out_id);
    $stmt->bindParam(':nameFile', $nameFile);
    $stmt->execute();

    $sql2 = "SELECT * FROM messages ORDER BY msg_id DESC LIMIT 1";
    $stmt2 = $pdo->query($sql2);
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    $msg_id = $row['msg_id'];

    $fileInfo = pathinfo($file['name']);
    $fileExtension = $fileInfo['extension'];

    $path = "chatfiles/" . $msg_id . "." . $fileExtension;
    
    move_uploaded_file($file['tmp_name'], $path);

  }

?>