<?php

session_start();
if (!isset($_SESSION['id'])) {
  header('Location: log_rej.php');
  exit();
}
require 'database/db_connection.php';

$sql = "SELECT * FROM views WHERE viewer_id = {$_SESSION['id']} AND seen = 1";

$numberofnotifications = $pdo->query($sql)->rowCount();

if ($numberofnotifications == 0) {
  echo "";
} else {
  echo $numberofnotifications;
}
