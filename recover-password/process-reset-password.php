<?php

session_start();

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM users
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    $_SESSION['error'] = '<span style="color:red">Nie znaleziono tokena!</span>';
    header("Location: ../log_rej.php");
    exit();
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    $_SESSION['error'] = '<span style="color:red">Token nieaktywny!</span>';
    header("Location: ../log_rej.php");
    exit();
}

if (strlen($_POST["password"]) < 8) {
    $_SESSION['ResetError'] = '<span style="color:red">Hasło musi mieć conajmiej 8 znaków!</span>';
    header("Location: reset-password.php?token=$token");
    exit();
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    $_SESSION['ResetError'] = '<span style="color:red">Hasła są różne!</span>';
    header("Location: reset-password.php?token=$token");
    exit();
}

$password_hash = hash('sha256', $_POST["password"]);
$sql = "UPDATE users
        SET user_password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE user_id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["user_id"]);

$stmt->execute();

echo "Password updated. You can now login.";
header('Location: ../log_rej.php?status=udanaZmianaHasla');
