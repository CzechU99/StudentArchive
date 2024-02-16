<?php
session_start();
require 'database/db_connection.php';

// Collect the parameters from the AJAX request
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$viewer_id = isset($_POST['viewer_id']) ? $_POST['viewer_id'] : null;

// Check if both parameters are set
if ($user_id !== null && $viewer_id !== null) {
  // Update the flag seen to 0 for records where user_id is equal to viewer_id
  $sql_update = "UPDATE views SET seen = 0 WHERE user_id = :user_id AND viewer_id = :viewer_id";
  $stmt_update = $pdo->prepare($sql_update);
  $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt_update->bindParam(':viewer_id', $viewer_id, PDO::PARAM_INT);
  $stmt_update->execute();

  // Optional: You can check the affected rows to see if any records were updated
  $affectedRows = $stmt_update->rowCount();
  if ($affectedRows > 0) {
    echo "Flag 'seen' updated to 0 for $affectedRows record(s).";
  } else {
    echo "No records were updated.";
  }
} else {
  echo "Missing parameters.";
}
