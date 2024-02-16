<?php
require_once 'database/db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['passwd']) && $_POST['email'] != '' && $_POST['passwd'] != '') {
        $email = $_POST['email'];
        $haslo = $_POST['passwd'];

        if($email == "Admin@student.pl" && $haslo == "Admin"){
            header('Location: admin.php');
            $_SESSION['id'] = "admin";
            exit();
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE users.user_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($stmt->rowCount() > 0 && $user['user_password'] == hash('sha256', $haslo)) {
            if ($user["user_account_activation"] != 1) {
                $_SESSION['error'] = '<span style="color:red">Wymagane potwierdzenie emial</span>';
                header('Location: log_rej.php');
                exit();
            } else if ($user["is_account_archived"] == 1) {
                $_SESSION['error'] = '<span style="color:red">Konto nieaktywne</span>';
                header('Location: log_rej.php');
                exit();
            }
            $_SESSION['zalogowany'] = true;
            $_SESSION['passwd'] = $haslo;
            $_SESSION['email'] = $user['user_email'];

            $stmt2 = $pdo->prepare("UPDATE users SET status = 1 WHERE users.user_email = :email");
            $stmt2->bindParam(':email', $email);
            $stmt2->execute();

            unset($_SESSION['error']);
            header('Location: user_profile.php');
            $_SESSION['id'] = $user['user_id'];
            exit();
            // Tutaj można dodać kod przekierowujący użytkownika na stronę z zasobami chronionymi
        } else {
            header("Location: log_rej.php?status=errorhaslo");
            exit();
        }
    } else {
        header("Location: log_rej.php?status=errorlogin");
        exit();
    }
}

if (isset($_SESSION['id'])) {
    header('Location: main.php');
} else {
    // Zmienna sesji nie istnieje
    header('Location: log_rej.php');
}
