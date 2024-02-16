<?php
  session_start();
  if (!isset($_SESSION['id'])) {
    header('Location: log_rej.php');
  }

  $id = $_SESSION['id'];
  $sciezkaGlowna = "users/" . $id;

  $plikiFolderuId = glob("users/" . $id . "/*");
  $liczbaPlikowId = count($plikiFolderuId);

  $path = "users/" . $id;
  
  mkdir($path . "/Semestr " .$liczbaPlikowId+1, 0777, true);

  header("Location: main.php");

?>