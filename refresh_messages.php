<?php 

            session_start();

            require 'database/db_connection.php';

            $sql2 = "UPDATE messages SET displayed = 1 WHERE in_msg_id = {$_SESSION['id']} AND out_msg_id = {$_GET['chat']}";
            $stmt2 = $pdo->query($sql2);

            $sql = "SELECT * FROM messages WHERE (out_msg_id = {$_SESSION['id']} AND in_msg_id = {$_GET['chat']}) OR (out_msg_id = {$_GET['chat']} AND in_msg_id = {$_SESSION['id']})";

            $stmt = $pdo->query($sql);

            echo "<div id='messages'>";
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

              if($row['file'] == 0){
                if($row['out_msg_id'] == $_SESSION['id']){
                  echo "<div class='msg_me'>".$row['msg_text']."</div>";
                }else{
                  echo "<div class='msg_you'>".$row['msg_text']."</div>";
                }
              }elseif($row['file'] == 1){
                if($row['out_msg_id'] == $_SESSION['id']){
                  echo "<div class='msg_me'><a class='aFile' href='chatfiles/".$row['msg_id'].".".pathinfo($row['msg_text'], PATHINFO_EXTENSION)."' download='". $row['msg_text'] ."'>".$row['msg_text']."</a></div>";
                }else{
                  echo "<div class='msg_you'><a class='aFileYou'  href='chatfiles/".$row['msg_id'].".".pathinfo($row['msg_text'], PATHINFO_EXTENSION)."' download='". $row['msg_text'] ."'>".$row['msg_text']."</a></div>";
                }
              }

            }
            echo "</div>";

?>