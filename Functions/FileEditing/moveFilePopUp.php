<?php
session_start();
$id = $_SESSION['id'];
if (isset($_POST['target'])) {
  $popSender = htmlspecialchars($_POST['target'], ENT_QUOTES, 'UTF-8');
} else {
  echo "Błąd: Brak przesłanych danych.";
}

if (isset($_POST['currentFolder'])) {
  $currentFolder = htmlspecialchars($_POST['currentFolder'], ENT_QUOTES, 'UTF-8');
} else {
  echo "Błąd: Brak przesłanych danych.";
}

if (isset($_POST['filePath'])) {
  $filePath = htmlspecialchars($_POST['filePath'], ENT_QUOTES, 'UTF-8');
} else {
  $filePath = '';
}

if (isset($_POST['fileTarget'])) {
  $fileTarget = htmlspecialchars($_POST['fileTarget'], ENT_QUOTES, 'UTF-8');
} else {
  $fileTarget = '';
}

if (isset($_POST['fileName'])) {
  $fileName = htmlspecialchars($_POST['fileName'], ENT_QUOTES, 'UTF-8');
} else {
  $fileName = '';
}

if (isset($_POST['editMode'])) {
  $editMode = htmlspecialchars($_POST['editMode'], ENT_QUOTES, 'UTF-8');
} else {
  $editMode = '';
}

echo "<div style=\"display: flex\"><div class='exit_div' onclick='closePopup()'>✖️</div>";

if ($popSender == "mainWindow") {
  echo "</div>";
  $sciezkaGlowna = "../../users/" . $id;

  $plikiFolderuId = glob("../../users/" . $id . "/*");
  $liczbaPlikowId = count($plikiFolderuId);

  if ($liczbaPlikowId !== 0) {
    $liczbaElementow = count(glob($sciezkaGlowna . '/*'));

    if ($liczbaElementow !== 0) {

      $semestry = scandir($sciezkaGlowna);
      $semestry = array_diff($semestry, array('.', '..'));

      $folder_counter = 0;

      foreach ($semestry as $semestr) {
        $folder_counter++;

        $sciezkaSemestru = $sciezkaGlowna . '/' . $semestr;

        if (is_dir($sciezkaSemestru)) {
          $sender = "popUpFile";
          echo "<div class='semesterFolder' onclick='openPopup(\"$sender\", \"$folder_counter\", this)' data-file-name=\"$fileName\" data-file-path=\"$filePath\" data-file-target=\"$sciezkaSemestru\" data-mode=\"$editMode\">";
          echo "<img src='Images/folderek.png'>";
          echo "<p>$semestr</p>";
          echo "</div>";
        }
      }
      echo "</div>";
    } else {
      echo "<div>Katalog nie ma folderów</div>";
    }
  }
} else {
  echo "<div>|</div>";
  echo "<div class='previous_div' onclick=\"openPopup('mainWindow', '', this)\" data-file-path=\"$filePath\" data-file-name=\"$fileName\" data-mode=\"$editMode\">🔙</div>";
  echo "<div>|</div>";
  echo "<div id=\"access-type\" class=\"checkbox-container\">
          <label>
            <input type=\"radio\" name=\"access\" value=\"public\"> Public
          </label>

          <label>
              <input type=\"radio\" name=\"access\" value=\"private\"> Private
          </label>
        </div>";
  echo "</div>";

  $currentSemester = $currentFolder;
  $semester = "Semestr " . "$currentSemester";
  $sciezkaGlowna = "../../users/" . $id . "/" . $semester;

  $plikiFolderuId = glob("../../users/" . $id . "/*");
  $liczbaPlikowId = count($plikiFolderuId);

  if ($liczbaPlikowId !== 0) {

    $liczbaElementow = count(glob($sciezkaGlowna . '/*'));

    if ($liczbaElementow !== 0) {

      $przedmioty = scandir($sciezkaGlowna);
      $przedmioty = array_diff($przedmioty, array('.', '..'));

      $filePath = '../../' . $filePath;

      foreach ($przedmioty as $przedmiot) {

        $sciezkaPrzedmiotu = $sciezkaGlowna . '/' . $przedmiot;

        if (is_dir($sciezkaPrzedmiotu)) {
          $fileTarget = $sciezkaPrzedmiotu;
          echo "<div class='semesterFolder'>";
          echo "<img src='Images/folderek.png'  onclick=\"moveFile(this, '$editMode')\" data-file-path=\"$filePath\" data-file-name=\"$fileName\" data-file-target=\"$fileTarget\")>";
          echo "<p>$przedmiot</p>";
          echo "</div>";
        }
      }
      echo "</div>";
    }
  }
}

echo "<div>";
echo "<div><b>Wybrany plik: </b></div>" . $fileName;
echo "<div></></div>";
echo "<div><b>Wykonywana operacja: </b></div>" . $editMode;
echo "</div>";



?>