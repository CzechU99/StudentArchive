<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Archive</title>
  <link rel="stylesheet" href="Styles/mainStyle.css?1">
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="Functions/main/selectedFolder/selectedFolder.js"></script>
  <script src="Functions/FileEditing/deleteFile.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="Functions/main/hide.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <script src="Functions/main/comments.js"></script>


  <script src="Functions/main/hide.js"></script>
</head>

<body>
  <?php

  session_start();
  if (!isset($_GET['userId'])) {
    header('Location: log_rej.php');
    exit();
  }
  ?>
  <div class="all">

    <div class="navbar">
      <p class="logo"><a href="main.php"> Student_Archive </a></p>

      <!-- habmurger -->
      <div class="wrapper-menu" id="znikaj">
        <div class="line-menu half start"></div>
        <div class="line-menu"></div>
        <div class="line-menu half end"></div>
      </div>

      <!-- to co widac normalnie -->
      <div class="navbar-right">
        <div id="user_search" class="search">
          <input id="search_input" type="text" placeholder="SZUKAJ...">
          <input type="submit" value="&#xe800;" />
        </div>

        <div id="search_result"></div>

        <button class="userButton"><a href="user_profile.php"><i class="userIcon">&#xf2be;</i></a></button>

        <button class="notificationButton"><a href="chatroom.php"><i class="chatIcon">&#xf4ac;</i>
            <div class="notifi"></div>
          </a></button>

        <script>
          function refreshNotifi() {

            $.ajax({
              url: "notification.php",
              method: "GET",

              success: function(data) {
                $(".notifi").html(data);
              }
            });

          }

          setInterval(refreshNotifi, 100);
        </script>

        <button class="notificationButton"><a href="powiadomienia.php"><i class="notificationIcon">&#xf0f3;</i>
          </a></button>
        <button class="logOutButton"><a href="logOut.php"><i class="logOutIcon">&#xe802;</i></a></button>
      </div>

    </div>



    <!-- to co widac po kliknieciu -->
    <div class="hamburger-menu-expanded" id="expanded-menu">

      <div class="hamburger_row">
        <div class="search">
          <input type="text" placeholder="SZUKAJ...">
          <input type="submit" value="&#xe800;" />
        </div>
      </div>

      <div class="hamburger_row">
        <div id="razem_button">
          <button class="logOutButton"><a href="logOut.php"><i class="logOutIcon">&#xe802;</i></a></button>
          <button class="notificationButton"><a href="powiadomienia.php"><i class="notificationIcon">&#xf0f3;</i>
            </a></button>
          <button class="userButton"><a href="user_profile.php"><i class="userIcon">&#xf2be;</i></a></button>
        </div>
      </div>

    </div>

    <!-- to co widac po kliknieciu -->
    <!-- to co widac po kliknieciu -->
    <div class="hamburger-menu-expanded" id="expanded-menu">

      <div class="hamburger_row">
        <div class="search">
          <input type="text" placeholder="SZUKAJ...">
          <input type="submit" value="&#xe800;" />
        </div>
      </div>

      <div class="hamburger_row">
        <div id="razem_button">
          <button class="logOutButton"><a href="logOut.php"><i class="logOutIcon">&#xe802;</i></a></button>
          <button class="notificationButton"><a href="powiadomienia.php"><i class="notificationIcon">&#xf0f3;</i>
            </a></button>
          <button class="userButton"><a href="user_profile.php"><i class="userIcon">&#xf2be;</i></a></button>
        </div>
      </div>

    </div>



    <script>
      function toggleNavbar() {
        const expandedMenu = document.getElementById("expanded-menu");
        if (expandedMenu.style.display === "block") {
          expandedMenu.style.display = "none";
        } else {
          expandedMenu.style.display = "block";
        }
      }

      $(window).resize(function() {
        if ($(window).width() > 983) {
          $('#znikaj').removeClass('open');
          document.getElementById('expanded-menu').style.display = 'none';
        }
      });

      var wrapperMenu = document.querySelector('.wrapper-menu');
      wrapperMenu.addEventListener('click', function() {
        wrapperMenu.classList.toggle('open');
        if (wrapperMenu.classList.contains('open')) {
          document.getElementById('expanded-menu').style.display = 'block';
        } else {
          document.getElementById('expanded-menu').style.display = 'none';
        }
      })
    </script>

    <?php

    require 'database/db_connection.php';

    $stmt2 = $pdo->prepare("UPDATE users SET status = 1 WHERE users.user_email = :email");
    $stmt2->bindParam(':email', $_SESSION['email']);
    $stmt2->execute();


    if (!isset($_GET['userId'])) {
      header('Location: log_rej.php');
      exit();
    }
    $userId = $_GET['userId'];
    
    include("database/db_connection.php");
    $query = "SELECT * FROM users WHERE user_id = '{$userId}'";
    $result = mysqli_query($db_connection, $query);

    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        $rowName = mysqli_fetch_assoc($result);
      }
    }

    
    if (isset($_SESSION['id']) && $_SESSION['id'] != $userId) {
      // Query to check if the record exists
      $sql_check = "SELECT view_id, view_date, seen FROM Views WHERE user_id = :user_id AND viewer_id = :viewer_id";
      $stmt_check = $pdo->prepare($sql_check);
      $stmt_check->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
      $stmt_check->bindParam(':viewer_id', $userId, PDO::PARAM_INT);
      $stmt_check->execute();

      if ($stmt_check->rowCount() == 0) {
        // Insert a new record if it doesn't exist
        $current_time = date("Y-m-d H:i:s");
        $sql_insert = "INSERT INTO views (user_id, viewer_id, view_date, seen) VALUES (:user_id, :viewer_id, :current_time, 1)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt_insert->bindParam(':viewer_id', $userId, PDO::PARAM_INT);
        $stmt_insert->bindParam(':current_time', $current_time, PDO::PARAM_STR);
        $stmt_insert->execute();
      } else {
        // Fetch data from an existing record
        $row = $stmt_check->fetch(PDO::FETCH_ASSOC);


        // Check the time difference
        $current_time = date("Y-m-d H:i:s");
        $diff_in_minutes = (strtotime($current_time) - strtotime($row['view_date'])) / 60;

        if ($diff_in_minutes > 5) {
          // Update the record if the time difference is more than 5 minutes
          $sql_update = "UPDATE views SET view_date = :current_time, seen = 1 WHERE view_id = :view_id";
          $stmt_update = $pdo->prepare($sql_update);
          $stmt_update->bindParam(':current_time', $current_time, PDO::PARAM_STR);
          $stmt_update->bindParam(':view_id', $row['view_id'], PDO::PARAM_INT);
          $stmt_update->execute();
        }
      }
    }



    ?>


    <div id="popover" class="hidden"></div>
    <div class=flex>

      <div class="content">

        <div class="contentTOP">

          <div class="nameInfo">

            <p class="userFullName">
              <?php echo (isset($rowName['user_name']) ? $rowName['user_name'] : '___') . " " . (isset($rowName['user_surname']) ? $rowName['user_surname'] : '___') ?>
            </p>
            <p class="userEmail">
              <?php echo (isset($rowName['user_email']) ? $rowName['user_email'] : '<b>Uzupełnij dane</b>') ?>
            </p>

          </div>



          <div class="semesters" id="semestersContainer">
            <?php

            $id = $userId;
            $sciezkaGlowna = "users/" . $id;

            $plikiFolderuId = glob("users/" . $id . "/*");
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

                    echo "<div class='semesterFolder' id='$folder_counter'>";
                    echo "<img src='Images/Folder.png'>";
                    echo "<p>$semestr</p>";
                    echo "</div>";
                  }
                }
              }
            }
            ?>
          </div>

        </div>

        <div class="contentBOTTOM">

          <?php

          $id = $userId;
          if (isset($_SESSION['selectedDivId'])) {
            $currentSemester = $_SESSION['selectedDivId'];
          } else {
            $_SESSION['selectedDivId'] = '1';
            $currentSemester = '1';
          }
          $semester = "Semestr " . "$currentSemester";
          $sciezkaGlowna = "users/" . $id . "/" . $semester;

          $plikiFolderuId = glob("users/" . $id . "/*");
          $liczbaPlikowId = count($plikiFolderuId);

          if ($liczbaPlikowId !== 0) {

            $liczbaElementow = count(glob($sciezkaGlowna . '/*'));

            if ($liczbaElementow !== 0) {
              $przedmioty = scandir($sciezkaGlowna);
              $przedmioty = array_diff($przedmioty, array('.', '..'));

              foreach ($przedmioty as $przedmiot) {

                $sciezkaPrzedmiotu = $sciezkaGlowna . '/' . $przedmiot;

                if (is_dir($sciezkaPrzedmiotu)) {

                  echo "<div class='Subject'>";
                  echo "<img src='Images/folderek.png' class='hideFolderSearch' >";
                  echo "<span class='subject_name'> $przedmiot</span>";


                  $foldery = ['public'];

                  foreach ($foldery as $folder) {

                    $sciezkaFolderu = $sciezkaPrzedmiotu . '/' . $folder;

                    if (is_dir($sciezkaFolderu)) {
                      echo "<div id >";
                      echo "<img class='mod_img toggleSearchDiv' src='Images/folderek.png' >";
                      echo "<span class='mod'> $folder</span>";

                      if ($folderHandler = opendir($sciezkaFolderu)) {

                        echo "<div class='FILE'>";
                        echo "<table cellpadding='1' cellspacing='1'>";

                        while (($plik = readdir($folderHandler)) !== false) {

                          if ($plik != "." && $plik != "..") {

                            $pelnaSciezkaPliku = $sciezkaFolderu . '/' . $plik;
                            echo "<tr>";
                            echo "<td><img src='Images/dokument.png'><a href='$pelnaSciezkaPliku' download><span>$plik</span></a></td>";


                            echo "<td style='padding-left:30px'>";

                            if (is_file($pelnaSciezkaPliku)) {

                              $rozmiarPlikuBajty = filesize($pelnaSciezkaPliku);
                              $rozmiarPlikuKilobity = $rozmiarPlikuBajty / 1024;
                              echo "<span>" . ceil($rozmiarPlikuKilobity) . " kilobitów</span>";
                            }
                            echo "</td>";
                            echo "<td><span onclick=\"zglos(this)\" data-file-path='$pelnaSciezkaPliku' data-file-name='$plik' data-owner='$id' data-mode='przenoszenie'>🚫</span>";
                            echo "<button id='commentsButton' type='button' style='background-color: white; color: gray; border-color: white' 
                                  class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#commentsModal'
                                  data-file-name='$plik' data-user-id='$id'>";
                            echo '<i class="fa-regular fa-comment"></i>';
                            echo '</button></td>';
                            echo "</tr>";
                          }
                        }
                        echo "</table>";
                        echo "</div>";
                        closedir($folderHandler);
                      }
                    }
                  }

                  echo "</div>";
                  echo "</div>";
                }
              }
            }
          }

          ?>
          <script>
            function wybierzPlik(element) {

              const input = element.nextElementSibling;
              input.click();

              input.addEventListener('change', function() {

                const plik = this.files[0];

                if (plik) {

                  const folder = this.getAttribute('data-folder');

                  const formData = new FormData();
                  formData.append('plik', plik);

                  fetch('upload.php?sciezka=' + folder, {

                      method: 'POST',
                      body: formData

                    })

                    .then(response => response.text())

                    .then(data => {


                      location.reload();

                    })

                }

              });

            }
          </script>

        </div>

      </div>

    </div>

  </div>

  <form style="display:none;" id="zgloszenie" action="zgloszenie.php" method="post">
    <input type="hidden" name="elementName" id="elementName" value="">
    <input type="hidden" name="elementPath" id="elementPath" value="">
    <input type="hidden" name="elementOwner" id="elementOwner" value="">
    <input type="hidden" name="komentarz" id="komentarz" value="">
  </form>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#search_input").keyup(function() {
        var search_input = $(this).val();

        if (search_input != "") {
          $.ajax({
            url: "Functions/main/search/livesearch.php",
            method: "POST",
            data: {
              search_input: search_input
            },

            success: function(data) {
              $("#search_result").html(data);
              console.log(search_input)
            }
          });
          $("#search_result").css("display", "block");
        } else {
          $("#search_result").css("display", "none");
          console.log("pusto")
        }

      });
    });

    window.addEventListener('beforeunload', function() {
      $.ajax({
        url: "offline.php",
        method: "POST",
        success: function(data) {
          console.log("wylogowano");
        }
      });
    });
  </script>

  <script type="text/javascript">
    function zglos(element) {
      var elementName = element.getAttribute('data-file-name');
      var elementPath = element.getAttribute('data-file-path');
      var elementOwner = element.getAttribute('data-owner');
      var komentarz = prompt("Komentarz do zgłoszenia:", "");
      if (!(komentarz == null || komentarz == "")) {
        //console.log(komentarz);
        //console.log(elementPath);
        //console.log(elementName);
        //console.log(elementOwner);
        document.getElementById('elementName').value = elementName;
        document.getElementById('elementPath').value = elementPath;
        document.getElementById('elementOwner').value = elementOwner;
        document.getElementById('komentarz').value = komentarz;
        document.getElementById('zgloszenie').submit();

      }


    }
  </script>

  <script>
    function showPopover(message, isSuccess) {
      var popover = document.getElementById('popover');
      popover.innerHTML = message;
      popover.style.backgroundColor = isSuccess ? '#4CAF50' : '#F44336';
      popover.style.color = '#fff';
      popover.style.display = 'block';

      setTimeout(function () {
        popover.style.display = 'none';
      }, 3000); // Ukryj popover po 3 sekundach
    }

    document.addEventListener('DOMContentLoaded', function () {
      var urlParams = new URLSearchParams(window.location.search);
      var status = urlParams.get('status');

      if (status === 'Zgloszenie') {
        showPopover('Twoje zgłoszenie zostało przyjęte.', true);
      }
      window.history.replaceState(null, '', window.location.pathname + "?userId=" + str($_GET["userId"]));
    });
  </script>

  <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="commentsModalLabel">Komentarze</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="commentsContainer" class="list-group">

            <!-- Można dodać więcej komentarzy w tym samym formacie -->
            <div class="list-group-item" style="background: #e4e4e4">
              <h5>Dodaj nowy komentarz</h5>
              <form id="newCommentForm">
                <div class="mb-3">
                  <textarea class="form-control" id="newComment" rows="1" maxlength="200" placeholder="Wpisz swój komentarz..."></textarea>
                </div>
                <button id="newCommentButton" type="submit" class="btn btn-primary">Dodaj Komentarz</button>
              </form>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
        </div>
      </div>
    </div>
  </div>




</body>

</html>