<?php
include '../../database/db_connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$file_name = $data['name'];
$file_owner = $data['owner'];

try {
  $sql = "SELECT comments.comment_content, users.user_email FROM comments
          INNER JOIN users ON comments.author_id = users.user_id 
          WHERE comments.file_owner_id = :fileOwner AND comments.file_name LIKE :fileName";

  $statement = $pdo->prepare($sql);
  
  $statement->bindParam(':fileOwner', $file_owner, PDO::PARAM_INT);
  $statement->bindParam(':fileName', $file_name, PDO::PARAM_STR);

  $statement->execute();

  $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($comments);
} catch (PDOException $e) {
  // Wysłanie wiadomości o błędzie w formacie JSON
  echo json_encode(['error' => $e->getMessage()]);
}
?>