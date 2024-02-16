<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["major_name"]) && "" != $_POST["major_name"] ) {
    $major_name = $_POST["major_name"];
  }
  else{
    header("Location: main.php?status=puste");
    exit();
  }
}


$id_nr = $_SESSION['id'];
$users_path = 'users';
$current_folder = $_SESSION['selectedDivId'];

$user_folder_path = $users_path .'/' . $id_nr;
$current_folder_path = $user_folder_path . '/Semestr ' . $current_folder;
$new_folder_path = $current_folder_path . '/' . $major_name;

echo $new_folder_path;

if (!file_exists($new_folder_path)) {
  if (mkdir($new_folder_path)) {
    mkdir($new_folder_path . "/public", 0777, true);
    mkdir($new_folder_path . "/private", 0777, true);
    header("Location: main.php");
    exit();
  } else {
    header("Location: main.php?status=puste");
    exit();
  }
} else {
  header("Location: main.php?status=istnieje");
  exit();
}

?>