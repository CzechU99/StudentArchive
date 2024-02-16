<?php

  session_start();

  require_once 'database/db_connection.php';

  $stmt2 = $pdo->prepare("UPDATE users SET status = 0 WHERE users.user_email = :email");
  $stmt2->bindParam(':email', $_SESSION['email']);
  $stmt2->execute();

  session_unset();
  session_destroy();

  header("Location: log_rej.php");
  exit(); 
?>


