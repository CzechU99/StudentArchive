<?php

  session_start();

  require 'database/db_connection.php';

  if($_POST['msg_text'] != "" && $_POST['in_id'] != "" && $_POST['out_id'] != ""){
    $in_id = $_POST['in_id'];
    $out_id = $_POST['out_id'];
    $msg_text = $_POST['msg_text'];

    $sql = "INSERT INTO messages (out_msg_id, in_msg_id, msg_text, displayed, file) VALUES (:in_id, :out_id, :msg_text, 0, 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':in_id', $in_id);
    $stmt->bindParam(':out_id', $out_id);
    $stmt->bindParam(':msg_text', $msg_text);
    $stmt->execute();
  }

?>