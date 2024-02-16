<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Archive</title>
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="Functions/main/selectedFolder/selectedFolder.js"></script>
  <script src="Functions/FileEditing/deleteFile.js"></script>
  <script src="Functions/main/hide.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="Styles/mainStyle.css?3">
  <link rel="stylesheet" href="Styles/multiselect-dropdown.css">


  <script src="Functions/main/showFilters.js"></script>
  <script src="Functions/main/sortBy.js"></script>
  <script src="Functions/main/comments.js"></script>

  <script type="text/javascript" src="https://cdn.weglot.com/weglot.min.js"></script>
  <script>
    Weglot.initialize({
      api_key: 'wg_388361ab704ac63100f5638014b0f9b93'
    });
  </script>

</head>

<body onload="dane()">

  <?php


  session_start();
  if (!isset($_SESSION['id'])) {
    header('Location: log_rej.php');
  }
  ?>

  <div id="popover" class="hidden"></div>
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

        <button class="userButton" data-toggle='tooltip' data-placement='top' title='Profil użytkownika'><a
            href="user_profile.php"><i class="userIcon">&#xf2be;</i></a></button>

        <button class="notificationButton" data-toggle='tooltip' data-placement='top' title='Czat'>
          <a href="chatroom.php"><i class="chatIcon">&#xf4ac;</i>
            <div class="notifi"></div>
          </a>
        </button>

        <script>
          function refreshNotifi() {

            $.ajax({
              url: "notification.php",
              method: "GET",

              success: function (data) {
                $(".notifi").html(data);
              }
            });

          }
          setInterval(refreshNotifi, 100);
        </script>

        <button class="notificationButton"><a href="powiadomienia.php" data-toggle='tooltip' data-placement='top'
            title='Powiadomienia'><i class="notificationIcon">&#xf0f3;</i> </a></button>

        <script>
          function refreshNotifi() {

            $.ajax({
              url: "notification_powiadomienia.php",
              method: "GET",

              success: function (data) {
                $(".pow").html(data);
              }
            });

          }
          setInterval(refreshNotifi, 200);
        </script>
        <button class="logOutButton"><a href="logOut.php" data-toggle='tooltip' data-placement='top' title='Wyloguj się'>
          <i class="logOutIcon">&#xe802;</i></a>
        </button>
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

          <button class="notificationButton"><a href="chatroom.php"><i class="chatIcon">&#xf4ac;</i>
              <div class="notifi"></div>
            </a></button>

          <button class="userButton" data-toggle='tooltip' data-placement='top' title='Profil użytkownika'><a
              href="user_profile.php"><i class="userIcon">&#xf2be;</i></a></button>
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

      $(window).resize(function () {
        if ($(window).width() > 983) {
          $('#znikaj').removeClass('open');
          document.getElementById('expanded-menu').style.display = 'none';
        }
      });

      var wrapperMenu = document.querySelector('.wrapper-menu');
      wrapperMenu.addEventListener('click', function () {
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

    ?>


    <div class=flex>

      <div class="content">

        <div class="contentTOP">

          <div class="nameInfo">

            <p class="userFullName">
              <?php echo (isset($_SESSION['name']) ? $_SESSION['name'] : '___') . " " . (isset($_SESSION['surname']) ? $_SESSION['surname'] : '___') ?>
            </p>
            <p class="userEmail">
              <?php echo (isset($_SESSION['email']) ? $_SESSION['email'] : '<b>Uzupełnij dane</b>') ?>
            </p>

          </div>

          <div class="semesters" id="semestersContainer">
            <?php

            $id = $_SESSION['id'];
            $sciezkaGlowna = "users/" . $id;

            $plikiFolderuId = glob("users/" . $id . "/*");
            $liczbaPlikowId = count($plikiFolderuId);

            if ($liczbaPlikowId !== 0) {

              $liczbaElementow = count(glob($sciezkaGlowna . '/*'));

              if ($liczbaElementow !== 0) {

                $semestry = scandir($sciezkaGlowna);

                $semestry = array_diff($semestry, array('.', '..'));
                natsort($semestry);


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

        <div id="contentBottom" class="contentBOTTOM">

          <div class="menu">

            <button type="button" class="menu_button btn btn-primary" data-bs-toggle="modal"
              data-bs-target="#myModal">+</button>

            <div class="modal fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="create_folder.php" method="post">
                    <div class="modal-header">
                      <h4 class="modal-title">Tworzenie Folderu</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="major_name">Nazwa Folderu:</label>
                        <input type="text" class="form-control" id="major_name" name="major_name">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                      <button type="submit" class="btn btn-primary">Utwórz Folder</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <button id="filtersBtn" type="button" class="menu_button btn btn-primary">
              <i class="fa-solid fa-filter"></i>
            </button>

            <button id="sortByFolders" type="button" class="menu_button btn btn-primary">
              <i class="fas fa-sort-alpha-up"></i>
              <i class="fa-solid fa-folder"></i>
            </button>

            <button id="sortByFiles" type="button" class="menu_button btn btn-primary">
              <i class="fas fa-sort-alpha-up"></i>
              <i class="fa-regular fa-file-lines"></i>
            </button>

            <div class="container">
              <div class="select-btn">
                <span class="btn-text">Wybierz Semestry</span>
                <span class="arrow-dwn">
                  <i class="fa-solid fa-chevron-down"></i>
                </span>
              </div>

              <ul class="list-items">
                <li class="allBtn checked" onclick="zaznacz()">
                  <span class="checkbox">
                    <i class="fa-solid fa-check check-icon"></i>
                  </span>
                  <span class="item-text">Wszystkie</span>
                </li>
                <hr>

                <?php
                if ($liczbaPlikowId !== 0) {

                  $liczbaElementow = count(glob($sciezkaGlowna . '/*'));

                  if ($liczbaElementow !== 0) {

                    $semestry = scandir($sciezkaGlowna);
                    $semestry = array_diff($semestry, array('.', '..'));
                    natsort($semestry);


                    $folder_counter = 0;

                    foreach ($semestry as $semestr) {
                      $folder_counter++;

                      $sciezkaSemestru = $sciezkaGlowna . '/' . $semestr;

                      if (is_dir($sciezkaSemestru)) {
                        ?>
                        <li class="item checked" value="<?= $folder_counter ?>">
                          <span class="checkbox">
                            <i class="fa-solid fa-check check-icon"></i>
                          </span>
                          <span class="item-text">
                            <?= $semestr ?>
                          </span>
                        </li>
                        <?php
                      }
                    }
                  }
                  if ($liczbaElementow < 10) {
                    ?>
                    <hr>
                    <li class="add">
                      <a href="addSemester.php"><span class="add-text">DODAJ SEMESTR</span></a>
                    </li>
                    <?php
                  }
                }

                ?>


              </ul>
            </div>

          </div>
          <?php

          $id = $_SESSION['id'];
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
                  $mainFolderName = str_replace(' ', '_', $przedmiot);
                  echo "<div class='Subject' data-folder-name='$przedmiot'>";
                  echo "<img src='Images/folderek.png' class='hideFolder' data-toggle='tooltip' data-placement='top' title='Zwiń/Rozwiń folder'>";
                  echo "<span class='subject_name'>
                $przedmiot 
                <span class='' data-type='folder' data-folder-name='.$przedmiot' data-file-path='$sciezkaPrzedmiotu' onclick='deleteFile(this)' data-toggle='tooltip' data-placement='top' title='Usuń folder'>
                -
                </span>
              </span>";

                  $foldery = ['public', 'private'];

                  foreach ($foldery as $folder) {

                    $sciezkaFolderu = $sciezkaPrzedmiotu . '/' . $folder;

                    $removingElement = 'folder_' . str_replace(' ', '_', $folder) . '_' . str_replace(' ', '_', $przedmiot);

                    if (is_dir($sciezkaFolderu)) {
                      echo "<div id='$removingElement'>";
                      echo "<img class='mod_img toggleDiv' src='Images/folderek.png' data-toggle='tooltip' data-placement='top' title='Zwiń/Rozwiń folder plik'>";
                      echo "<span class='mod '> $folder</span>";
                      echo "<span class='plusik' onclick='wybierzPlik(this)' data-toggle='tooltip' data-placement='top' title='Dodaj plik'>+</span>";
                      echo "<input type='file' class='fileInput' style='display: none;' data-folder='$sciezkaFolderu'>";
                      echo "<span class='plusik' data-folder-name='$removingElement' data-folder-path='$sciezkaFolderu' onclick='multiDelete(this)' data-toggle='tooltip' data-placement='top' title='Usuń wiele plików'>-</span>";
                      echo "<span class='plusik hidden' id='deleteFilesBtn_$removingElement' data-folder-name='$removingElement' data-folder-path='$sciezkaFolderu' onclick='usunPliki(this)'>✓</span>";

                      if ($folderHandler = opendir($sciezkaFolderu)) {

                        echo "<div class='FILE sibling'>";
                        echo "<table class='filesTable' cellpadding='1' cellspacing='1'>";

                        while (($plik = readdir($folderHandler)) !== false) {

                          if ($plik != "." && $plik != "..") {

                            $pelnaSciezkaPliku = $sciezkaFolderu . '/' . $plik;

                            $nazwaPlikuSkladowe = explode('.', $plik);
                            $rozszerzenie = array_pop($nazwaPlikuSkladowe);
                            $nazwa = implode('.', $nazwaPlikuSkladowe);

                            if (is_file($pelnaSciezkaPliku)) {
                              $rozmiarPlikuBajty = filesize($pelnaSciezkaPliku);
                              $rozmiarPlikuKilobity = $rozmiarPlikuBajty / 1024;
                            }

                            echo "<tr class='file-row' data-name='$nazwa' data-size='$rozmiarPlikuKilobity' data-extension='$rozszerzenie'>";
                            echo "<td><img src='Images/dokument.png'><a href='$pelnaSciezkaPliku' download><span>$plik</span></a></td>";

                            echo "<td style='padding-left:30px'>";

                            if ($rozmiarPlikuKilobity) {
                              echo "<span>" . ceil($rozmiarPlikuKilobity) . " kilobitów</span>";
                            }

                            echo "<span onclick=\"openPopup('mainWindow', '', this)\" data-file-path='$pelnaSciezkaPliku' data-file-name='$plik' data-mode='przenoszenie'>
                                    <span data-toggle='tooltip' data-placement='top' title='Przenieś plik do:'>↩️</span>
                                  </span>";

                            echo "<span onclick=\"openPopup('mainWindow', '', this)\" data-file-path='$pelnaSciezkaPliku' data-file-name='$plik' data-mode='kopiowanie'>
                                    <span data-toggle='tooltip' data-placement='top' title='Kopiuj plik do:'>📄</span>
                                  </span>";

                            echo "<span onclick=\"deleteFile(this)\" title='Usuń plik' data-file-path='$pelnaSciezkaPliku' data-description='$plik' data-toggle='tooltip' data-placement='top' >
                                    🗑️
                                  </span>";

                            echo "<span class='descriptionPopover' data-description='$id/$plik' data-container='body' data-toggle='popover' data-placement='top' title='Opis pliku'>
                                    <span data-toggle='tooltip' data-placement='top' title='Opis pliku'>|ℹ️|</span>
                                  </span>";

                            echo "<input type='checkbox' class='$removingElement hidden' data-file-path='$pelnaSciezkaPliku'>";

                            echo "<button id='commentsButton' type='button' style='background-color: white; color: gray; border-color: white' 
                                  class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#commentsModal'
                                  data-file-name='$plik' data-user-id='$id'>";
                            echo '<i class="fa-regular fa-comment" data-toggle="tooltip" data-placement="top" title="Komentarze"></i>';
                            echo '</button>';

                            echo "</td>";
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
                  echo "</div>";
                }
              }
            }
          }

          ?>
          <script>
            function setDescription() {
              $(document).ready(function () {
                $('.descriptionPopover').popover({
                  html: true,
                  content: function () {
                    const descriptionElement = document.createElement('div');
                    descriptionElement.id = 'fileDescription';
                    return descriptionElement;
                  },
                  trigger: 'manual'
                });

                function closeOtherPopovers(currentPopover) {
                  $('.descriptionPopover').not(currentPopover).popover('hide');
                }

                $('body').on('click', function (e) {
                  $('.descriptionPopover').each(function () {
                    if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                      $(this).popover('hide');
                    }
                  });
                });

                $('.descriptionPopover').on('click', function () {
                  const nazwaPliku = $(this).data('description');
                  fileDecription(nazwaPliku);

                  closeOtherPopovers(this);

                  $(this).popover('toggle');
                });
              });
            }

            setDescription();

            function fileDecription(nazwaPliku) {
              const sciezkaOpisow = 'tagdesc/';
              const sciezkaOpisu = sciezkaOpisow + nazwaPliku + '_opis.txt';;

              fetch(sciezkaOpisu)
                .then(response => {
                  if (response.status === 404) {
                    throw new Error('Plik nie został znaleziony');
                  }
                  if (!response.ok) {
                    throw new Error(`Błąd pobierania danych. Kod błędu: ${response.status}`);
                  }
                  return response.text();
                })
                .then(opis => {
                  const opisPlikuElement = document.getElementById('fileDescription');
                  opisPlikuElement.textContent = opis !== null ? opis : 'Brak opisu';
                })
                .catch(error => {
                  console.error(error.message);
                  const opisPlikuElement = document.getElementById('fileDescription');
                  opisPlikuElement.textContent = error.message === 'Brak opisu' ? 'Brak opisu' : 'Brak opisu';
                });
            }
          </script>


          <script>
            function wybierzPlik(element) {
              const input = element.nextElementSibling;
              input.click();

              input.addEventListener('change', function () {
                const plik = this.files[0];

                if (plik) {
                  const folder = this.getAttribute('data-folder');
                  let opis;

                  do {
                    opis = prompt('Podaj opis pliku: ');

                    if (opis.length > 100) {
                      alert('Opis pliku nie może przekraczać 100 znaków. Proszę podać krótszy opis.');
                    }
                  } while (opis.length > 1000);

                  const formData = new FormData();
                  formData.append('plik', plik);
                  formData.append('opis', opis);

                  fetch('upload.php?sciezka=' + folder, {
                    method: 'POST',
                    body: formData
                  })
                    .then(response => response.text())
                    .then(data => {
                      logEvent("Dodanie pliku", "NOWY PLIK", plik.name);
                      location.reload();
                    });
                }
              });
            }

            function logEvent(eventType, eventDetails, fileName) {
              const eventInfo = {
                type: eventType,
                details: eventDetails,
                fileName: fileName,
                timestamp: new Date().toISOString()
              }


              fetch("Functions/main/logActionRegister.php", {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify(eventInfo),
              })
                .then(response => response.json())
                .then(data => console.log(data))
                .catch((error) => console.error('Error:', error));
            }
          </script>
        </div>
      </div>
    </div>

  </div>


  <script type="text/javascript">
    $(document).ready(function () {
      $("#search_input").keyup(function () {
        var search_input = $(this).val();

        if (search_input != "") {
          $.ajax({
            url: "Functions/main/search/livesearch.php",
            method: "POST",
            data: {
              search_input: search_input
            },

            success: function (data) {
              $("#search_result").html(data);
            }
          });
          $("#search_result").css("display", "block");
        } else {
          $("#search_result").css("display", "none");
          console.log("pusto")
        }
      });
    });

    window.addEventListener('beforeunload', function () {
      $.ajax({
        url: "offline.php",
        method: "POST",
        success: function (data) {
          console.log("wylogowano");
        }
      });
    });
  </script>
  <script src="Functions/main/multiselect-dropdown.js"></script>

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

      if (status === 'istnieje') {
        showPopover('Folder o podanej nazwie juz istnieje', false);
      } else if (status === 'puste') {
        showPopover('Nie podano nazwy folderu', false);
      }
      window.history.replaceState(null, '', window.location.pathname);
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
                  <textarea class="form-control" id="newComment" rows="1" maxlength="200"
                    placeholder="Wpisz swój komentarz..."></textarea>
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