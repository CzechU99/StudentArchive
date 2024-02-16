<?php 
            session_start();

            require 'database/db_connection.php';

            if($_GET['text'] == ""){
              $sql = "SELECT * FROM users ORDER BY status DESC";
            }else{
              $sql = "SELECT * FROM users WHERE user_name LIKE '%{$_GET['text']}%' OR user_surname LIKE '%{$_GET['text']}%' OR user_email LIKE '%{$_GET['text']}%' ORDER BY status DESC";
            }
                       
            $stmt = $pdo->query($sql);

            $sql3 = "SELECT * FROM messages WHERE in_msg_id = {$_SESSION['id']} AND out_msg_id != {$_SESSION['id']} AND displayed = 0 GROUP BY out_msg_id;";

            $stmt3 = $pdo->query($sql3);

            $to_read = array();

            while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
              array_push($to_read, $row3['out_msg_id']);
            }

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

              echo "<a class='link' href='chat.php?chat={$row['user_id']}'><div class='user_chat'>";

                echo "<div class='user_icon'><i class='userIcon2'>&#xf2be;</i></div>";

                echo "<div class='user_name'>";    
                  if($row['user_name'] != NULL && $row['user_surname'] != NULL){      
                    echo $row['user_name']." ".$row['user_surname']; 
                  }else{
                    echo $row['user_email'];
                  }
                echo "</div>";

                echo "<div class='last_msg'>";

                  $sql2 = "SELECT * FROM messages WHERE (out_msg_id = {$_SESSION['id']} AND in_msg_id = {$row['user_id']}) OR (out_msg_id = {$row['user_id']} AND in_msg_id = {$_SESSION['id']}) ORDER BY msg_id DESC LIMIT 1";

                  $stmt2 = $pdo->query($sql2);

                  $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                  if(!empty($row2)){
                    if(in_array($row['user_id'], $to_read)){
                      echo "<div class='msg_text2'>".$row2['msg_text']."</div>";
                    }else{
                      echo $row2['msg_text'];
                    }
                  }else{
                    echo "Rozpocznij waszą pierwszą rozmowę!";
                  }
                
                echo "</div>";

                if($row['status'] == 1){
                  echo "<div class='dot_place2'><div class='green_dot2'>&#x2022;</div></div>";
                }else{
                  echo "<div class='dot_place2'><div class='red_dot2'>&#x2022;</div></div>";
                }

              echo "</div>";

              echo "<div class='kreska'></div></a>";

            }
                                                                                      
          ?>  