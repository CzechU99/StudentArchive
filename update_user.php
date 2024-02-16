<?php 

session_start();

require_once 'database/db_connection.php';

$id = $_GET['id'];

if(isset($_POST['update_user'])){


    if(isset($_POST['name']) && $_POST['name'] != ""){
      $name = $_POST['name'];
      $sql = "UPDATE users SET user_name = '$name' WHERE user_id = '$id'";
      $result = $pdo->query($sql);
      unset($_SESSION['name']);
    }

    if(isset($_POST['surname']) && $_POST['surname'] != ""){
      $surname = $_POST['surname'];
      $sql = "UPDATE users SET user_surname = '$surname' WHERE user_id = '$id'";
      $result = $pdo->query($sql);
      unset($_SESSION['surname']);
    }

    if(isset($_POST['email']) && $_POST['email'] != ""){
      $email = $_POST['email'];
      $sql = "UPDATE users SET user_email = '$email' WHERE user_id = '$id'";
      $result = $pdo->query($sql);
      unset($_SESSION['email']);
    }

    if(isset($_POST['uczelnia']) && $_POST['uczelnia'] != $_SESSION['university']){
      $university = $_POST['uczelnia'];
      $sql = "UPDATE users SET universities_id = '$university' WHERE user_id = '$id'";
      $result = $pdo->query($sql);
      unset($_SESSION['uczelnia']);
    }

    if(isset($_POST['kierunek']) && $_POST['kierunek'] != $_SESSION['major']){
      $major = $_POST['kierunek'];
      $sql = "UPDATE users SET major_id = '$major' WHERE user_id = '$id'";
      $result = $pdo->query($sql);
      unset($_SESSION['kierunek']);
    }

    header("Location: user_profile.php");

}

if(isset($_POST['update_user_pass'])){

  $stmt = $pdo->prepare("SELECT * FROM users WHERE users.user_id = :id");
  $stmt->bindParam(':id', $_SESSION['id']);
  $stmt->execute();
  $user = $stmt->fetch();


  if (($stmt->rowCount() > 0 && $user['user_password'] == hash('sha256', $_POST['old_passwd']))) 
  {
      if((hash('sha256', $_POST['new_passwd']) == hash('sha256', $_POST['new_passwd2'])) && strlen($_POST['new_passwd']) > 7){
        $passwd = hash('sha256', $_POST['new_passwd']);
        $sql = "UPDATE users SET user_password = '$passwd' WHERE user_id = '$id'";
        $result = $pdo->query($sql);
        header("Location: user_profile.php?status=githaslo");
        exit();
      }
      else
      {
        header("Location: user_profile.php?status=errorhaslo");
        exit();
      } 
  }
  else
  {
      header("Location: user_profile.php?status=errorhaslostare");
      exit();
  }
    
    

}

if (isset($_SESSION['id'])) {
 //header('Location: user_profile.php');
} else {
  header('Location: log_rej.php');
}

?>