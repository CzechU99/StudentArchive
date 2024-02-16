<?php
// KLUCZE CAPTCHY
//  Klucz witryny: 6LfTHyEpAAAAAESKLz2KMX8W-GiWoL8GVAyhHmHN
//  Klucz serwera (tajny): 6LfTHyEpAAAAAA5JKg-q6FyZr9a3rHXKKhEoFx1- 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $haslo = $_POST["haslo"];
    $haslo2 = $_POST["haslo2"];
    $uczelnia = $_POST["uczelnia"];


    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 
 
        // Weryfikacja Captchy
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LfTHyEpAAAAAA5JKg-q6FyZr9a3rHXKKhEoFx1-&response='.$_POST['g-recaptcha-response']); 
        $responseData = json_decode($verifyResponse); 
         
        // reCAPTCHA GIT
        if($responseData->success){
            try {
                $query = "SELECT * FROM users WHERE users.user_email = :email";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    header("Location: log_rej.php?status=errorEmail");
                    exit();
                } else {
                    $hashedPassword = hash('sha256', $haslo);
                    // Dodaj dane do bazy danych
                    $activation_token = bin2hex(random_bytes(16));

                    $activation_token_hash = hash("sha256", $activation_token);

                    $insertQuery = "INSERT INTO users (users.user_email, users.user_password, users.account_activation_hash) VALUES (:email, :haslo, :token)";
                    $insertStmt = $pdo->prepare($insertQuery);
                    $insertStmt->bindParam(':email', $email);
                    $insertStmt->bindParam(':haslo', $hashedPassword);
                    $insertStmt->bindParam(':token', $activation_token_hash);
                    //$insertStmt->bindParam(':uczelnia', $uczelnia);


                    $idQuery = "SELECT MAX(user_id) FROM users";
                    $lastId = $pdo->query($idQuery);
                    $lastId = $lastId->fetch(PDO::FETCH_ASSOC);
                    $lastId = $lastId['MAX(user_id)'];
                    $newId = $lastId + 1;



                    // if (!file_exists($baseFolder)) {
                    //     mkdir($baseFolder, 0777, true);

                    //     mkdir($baseFolder . '/Semestr 1', 0777, true);
                    //     mkdir($baseFolder . '/Semestr 2', 0777, true);
                    //     mkdir($baseFolder . '/Semestr 3', 0777, true);
                    //     mkdir($baseFolder . '/Semestr 4', 0777, true);
                    //     mkdir($baseFolder . '/Semestr 5', 0777, true);
                    //     mkdir($baseFolder . '/Semestr 6', 0777, true);
                    //     mkdir($baseFolder . '/Semestr 7', 0777, true);
                    //     mkdir($baseFolder . '/Semestr 8', 0777, true);
                    //     mkdir($baseFolder . '/Semestr 9', 0777, true);
                    // }

                    if ($insertStmt->execute()) {

                        require __DIR__ . "/vendor/autoload.php";

                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->SMTPAuth = true;

                        $mail->SMTPOptions = array(
                            'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true,
                            )
                        );

                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = 'tls';

                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                        $mail->Username = "student.archive.smtp@gmail.com";
                        $mail->Password = "ebpr egoe arzf qhvi";

                        $mail->isHtml(true);

                        $mail->setFrom("noreply@example.com");
                        $mail->addAddress($_POST["email"]);
                        $mail->Subject = "Account Activation";
                        $mail->Body = <<<END

                        Click <a href="http://localhost/P1D3-StudentArchive/activate-account.php?token=$activation_token">here</a> 
                        to activate your account
                        END;

                        try {

                            $mail->send();
                        } catch (Exception $e) {

                            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                            exit;
                        }

                        $email = '';
                        $haslo = '';
                        $haslo2 = '';
                        $uczelnia = '';

                        header("Location: log_rej.php?status=success");
                        exit();
                    } else {
                        header("Location: log_rej.php?status=error");
                        exit();
                    }
                }
            } catch (PDOException $e) {
                die("Błąd połączenia z bazą danych: " . $e->getMessage());
            }
        }
        else
        { 
            //Jakby zle potwierdzenie
            header("Location: log_rej.php?status=errorCaptcha");
        }
    }
    else
    { 
        // Nie zaznaczona
        header("Location: log_rej.php?status=errorNoCaptcha");
    }
}

// if (isset($_SESSION['id'])) {
//     header('Location: main.php');
// } else {
//     // Zmienna sesji nie istnieje
//     header('Location: log_rej.php?status=error');
//     exit();
// }