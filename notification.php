<?php 

  session_start();
  require 'database/db_connection.php';

  $sql = "SELECT * FROM messages WHERE in_msg_id = {$_SESSION['id']} AND out_msg_id != {$_SESSION['id']} AND displayed = 0 GROUP BY out_msg_id;";
  
  $numberofnotifications = $pdo->query($sql)->rowCount();

  if($numberofnotifications == 0){
    echo "";
  }else{
    echo $numberofnotifications;
  }

?>