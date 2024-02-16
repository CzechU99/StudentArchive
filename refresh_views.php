<?php
if (!isset($_SESSION)) {
  session_start();
}
require 'database/db_connection.php';

$sql3 = "SELECT * FROM views WHERE viewer_id = {$_SESSION['id']} ORDER BY view_date DESC";
$stmt3 = $pdo->query($sql3);

$seen_array = array();
$time_array = array();
$name_array = array();
$surname_array = array();
$email_array = array();
$viewer_array = array();

while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
  $sql = "SELECT * FROM users WHERE  user_id = {$row3['user_id']};";
  $stmt = $pdo->query($sql);
  $userResult = $stmt->fetch(PDO::FETCH_ASSOC);
  array_push($seen_array, $row3['seen']);
  array_push($time_array, $row3['view_date']);
  array_push($name_array, $userResult['user_name']);
  array_push($surname_array, $userResult['user_surname']);
  array_push($email_array, $userResult['user_email']);
  array_push($viewer_array, $row3['user_id']);
}

$arrayLength = count($seen_array);
for ($i = 0; $i < $arrayLength; $i++) {

  // echo "<a class='link' href='serched_user.php?userId=20'><div class='user_chat'>";
  echo "<a class='triggerScriptLink link ' href='serched_user.php?userId={$viewer_array[$i]}' data-user-id='{$viewer_array[$i]}' data-viewer-id='{$_SESSION['id']}'><div class='user_chat'>";

  echo "<div class='user_icon'><i class='userIcon2'>&#xf2be;</i></div>";

  echo "<div class='user_name'>";
  if ($name_array[$i] != NULL && $surname_array[$i] != NULL) {
    echo $name_array[$i] . " " . $surname_array[$i];
  } else {
    echo $email_array[$i];
  }
  echo "</div>";

  echo "<div class='last_msg'>";



  echo "Wyswietlono : " . $time_array[$i];
  echo "</div>";

  if ($seen_array[$i] == 1) {
    echo "<div class='dot_place2'><div class='blue_dot2'>&#x2022;</div></div>";
  } else {
    echo "<div class='dot_place2'><div class='red_dot2'>&#x2022;</div></div>";
  }

  echo "</div>";

  echo "<div class='kreska'></div></a>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <script type="text/javascript">
    window.addEventListener('beforeunload', function() {
      $.ajax({
        url: "offline.php",
        method: "POST",
        success: function(data) {
          console.log("wylogowano");
        }
      });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".triggerScriptLink").on("click", function(e) {
        e.preventDefault();

        // Get the data attributes
        var userId = $(this).data("user-id");
        var viewerId = $(this).data("viewer-id");

        // Make an AJAX request to your PHP script with the parameters
        $.ajax({
          url: "view_notification.php",
          method: "POST",
          data: {
            user_id: userId,
            viewer_id: viewerId
          },
          success: function(response) {
            // Handle the response from the PHP script
            console.log(response);

            // Redirect after the AJAX request is successful
            window.location.href = "serched_user.php?userId=" + userId;
          },
          error: function(xhr, status, error) {
            // Handle errors

            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>
</body>

</html>