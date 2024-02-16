<?php
session_start();
require '../../database/db_connection.php';

if(isset($_POST['comment_content']) && isset($_POST['file_owner']) && isset($_POST['file_name'])) {
    $comment_content = $_POST['comment_content'];
    $author_id = $_SESSION['id'];
    $file_owner_id = $_POST['file_owner'];
    $file_name = $_POST['file_name'];

    try {
        $sql = "INSERT INTO comments (comment_content, author_id, file_owner_id, file_name) VALUES (:comment_content, :author_id, :file_owner_id, :file_name)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':comment_content', $comment_content);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':file_owner_id', $file_owner_id);
        $stmt->bindParam(':file_name', $file_name);

        if($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Komentarz został dodany']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Nie udało się dodać komentarza']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Błąd serwera: '.$e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Brakujące dane']);
}
?>