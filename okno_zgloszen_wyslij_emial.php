<?php
// Include the necessary files and initialize the session if not already done

session_start();

// Assuming you have a database connection established (you mentioned $pdo in the original code)

// Process the form submission
if (isset($_POST['update_user'])) {

  // Sanitize and validate input data (you may need to improve this based on your requirements)
  $temat = isset($_POST['temat']) ? htmlspecialchars($_POST['temat']) : '';
  $kategoria = isset($_POST['kategoria']) ? htmlspecialchars($_POST['kategoria']) : '';
  $wiadomosc = isset($_POST['wiadomosc']) ? htmlspecialchars($_POST['wiadomosc']) : '';

  // Insert your database update logic here using prepared statements
  // For example, you can insert these values into your database table

  // Send email
  $mail = require __DIR__ . "/recover-password/mailer.php";

  $mail->setFrom($_SESSION['email']);
  $mail->addAddress("student.archive.smtp@gmail.com"); // Replace with the actual recipient email address
  $mail->Subject = $temat . " from " . $_SESSION['email'];
  $mail->Body = "Kategoria: $kategoria\n\nWiadomość:\n $wiadomosc";

  try {
    $mail->send();
    echo "Email sent successfully.";
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
  }
}
header('Location: user_profile.php');
