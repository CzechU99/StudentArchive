<?php

session_start();
unset($_SESSION['error']);
if (isset($_SESSION['id'])) {
    header('Location: main.php');
}
$token = $_GET["token"];

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
    $_SESSION['error'] = '<span style="color:red">Token wygasł!</span>';
    header("Location: ../log_rej.php");
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/style_log.css">
    <link rel="stylesheet" href="../Styles/validation.css">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
</head>

<body>
    <div id="container">

        <div id="header">

            <div id="title">Student_Archive</div>

        </div>

        <div id="panel">

            <div id="popover" class="hidden"></div>

            <form method="post" action="process-reset-password.php">
                <div id="logowanie">

                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                    <div id="log_tekst">Resetowanie hasła</div>
                    <?php
                    if (isset($_SESSION['ResetError']))
                        echo $_SESSION['ResetError'];
                    ?>
                    <div id="log_email">Nowe:</div>
                    <input id="log_email_input" type="password" name="password" placeholder="Podaj hasło...">

                    <div id="log_haslo">Powtórz:</div>
                    <input id="log_haslo_input" type="password" name="password_confirmation" placeholder="Podaj hasło...">

                    <div id="log_przyciski">
                        <input id="log_przycisk_zaloguj" type="submit" value="ZRESETUJ">
                    </div>

                    <div id="krecha"></div>

                </div>
            </form>

        </div>

    </div>

    </div>

    </div>

    <!-- <div id="container">
        <div id="panel">
            <form method="post" action="process-reset-password.php">
                <div id="logowanie">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <div id="log_tekst">Logowanie</div>

                    <div id="log_email"> password</div>
                    <input type="password" id="log_haslo_input" name="password" placeholder="Podaj haslo...">

                    <div id="log_email">Repeat password</div>
                    <input type="password" id="log_haslo_input" name="password_confirmation" placeholder="Podaj haslo...">
                    <input type="submit" value="RESETUJ">
                </div>
            </form>
        </div>
    </div> -->

</body>

</html>