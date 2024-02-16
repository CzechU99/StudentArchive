<?php


require 'database/db_connection.php';

if (isset($_POST['usun'])) {
  $targetUserId = $_POST['user_id'];


  try {
      $stmt = $pdo->prepare("SELECT is_account_archived FROM users WHERE user_id = :userId");
      $stmt->bindParam(':userId', $targetUserId, PDO::PARAM_INT);
      $stmt->execute();
      $currentIsAccountArchived = $stmt->fetchColumn();

      $newIsAccountArchived = $currentIsAccountArchived == 0 ? 1 : 0;

      // Aktualizacja rekordu w bazie danych
      $updateStmt = $pdo->prepare("UPDATE users SET is_account_archived = :newIsAccountArchived WHERE user_id = :userId");
      $updateStmt->bindParam(':newIsAccountArchived', $newIsAccountArchived, PDO::PARAM_INT);
      $updateStmt->bindParam(':userId', $targetUserId, PDO::PARAM_INT);
      $updateStmt->execute();


  } catch (PDOException $e) {
      die("Błąd podczas pobierania/dodawania danych: " . $e->getMessage());
  }

  $pdo = null;

}
header('Location: admin.php');
?>
