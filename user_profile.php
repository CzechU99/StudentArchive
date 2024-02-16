<!DOCTYPE html>
<html>

<head>

  <title>StudentArchive</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Styles/style_user.css?1">
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script type="text/javascript" src="https://cdn.weglot.com/weglot.min.js"></script>
  <script>
    Weglot.initialize({
      api_key: 'wg_388361ab704ac63100f5638014b0f9b93'
    });
  </script>

</head>

<body>

  <?php
  session_start();
  if (!isset($_SESSION['id'])) {
    header('Location: log_rej.php');
    exit();
  }
  ?>

  <div id="container">


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

    if (!isset($_SESSION['id'])) {
      header('Location: user_profile.php');
    }

    $id = $_SESSION['id'];

    $stmt2 = $pdo->prepare("UPDATE users SET status = 1 WHERE users.user_email = :email");
    $stmt2->bindParam(':email', $_SESSION['email']);
    $stmt2->execute();

    $sql = "SELECT * FROM users JOIN universities ON id_universities = universities_id JOIN majors ON id_major = major_id WHERE user_id = '$id'";
    $result = $pdo->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    @$_SESSION['name'] = $row['user_name'];
    @$_SESSION['surname'] = $row['user_surname'];
    @$_SESSION['major'] = $row['major_name'];
    @$_SESSION['university'] = $row['name_univeristy'];
    @$_SESSION['passwd'] = $row['user_password'];

    @$_SESSION['check_uni'] = $row['universities_id'];
    @$_SESSION['check_maj'] = $row['major_id'];

    ?>
    <div id="popover" class="hidden"></div>
    <div id="bg">

      <div id="panel">

        <div id="top">

          <?php
          echo "<div id='base_inf'>";
          echo "<div id='imie'>" . (isset($_SESSION['name']) ? $_SESSION['name'] : '___') . " " . (isset($_SESSION['surname']) ? $_SESSION['surname'] : '___') . "</div>";
          echo "<div id='email_show'>" . (isset($_SESSION['email']) ? $_SESSION['email'] : '<b>Uzupełnij dane</b>') . "</div>";
          echo "<div id='status'>Status: Student</div>";
          echo "<div id='uczelnia'>" . (isset($_SESSION['university']) ? "Uczelnia: " . $_SESSION['university'] : '<b>Uzupełnij dane</b>') . "</div>";
          echo "<div id='kierunek'>" . (isset($_SESSION['major']) ? "Kierunek: " . $_SESSION['major'] : '<b>Uzupełnij dane</b>') . "</div>";
          echo "</div>";
          ?>

          <div id="detail_inf">

            <div id="chart">
              <canvas id="fileSizeChart" width="200" height="200"></canvas>
            </div>

            <div class="fileamount_number up">
              <?php
              $sciezka = 'users/' . $_SESSION['id'];
              function zliczPliki($sciezka)
              {
                $licznik = 0;
                $katalog = opendir($sciezka);
                while ($element = readdir($katalog)) {
                  if ($element != "." && $element != "..") {
                    $pelnaSciezka = $sciezka . '/' . $element;
                    if (is_file($pelnaSciezka)) {
                      $licznik++;
                    } elseif (is_dir($pelnaSciezka)) {
                      $licznik += zliczPliki($pelnaSciezka);
                    }
                  }
                }
                closedir($katalog);
                return $licznik;
              }
              $iloscPlikow = zliczPliki($sciezka);
              echo "LICZBA PLIKÓW: " . $iloscPlikow;
              ?>

            </div>

            <div class="fileamount_number">

              <?php

              $path = 'users/' . $_SESSION['id'];

              if ($path) {
                $totalSize = 0;
                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
                foreach ($files as $file) {
                  if ($file->isFile()) {
                    $totalSize += $file->getSize();
                  }
                }
                echo "ZUŻYCIE DYSKU: " . round(((round($totalSize / (1024 * 1024), 2) / 512) * 100), 2) . "%";
              } else {
                echo "ZUŻYCIE DYSKU: 0%";
              }
              ?>
            </div>

            <div class="fileamount_number2">

              <?php

              require 'database/db_connection.php';

              $sql = "SELECT count(*), in_msg_id FROM `messages` WHERE out_msg_id = " . $_SESSION['id'] . " GROUP BY in_msg_id ORDER BY count(*) DESC LIMIT 1";

              $result = $pdo->query($sql);
              $row = $result->fetch(PDO::FETCH_ASSOC);



              if ($row !== false) {

                $sql2 = "SELECT user_name, user_surname FROM users WHERE user_id = " . $row['in_msg_id'];

                $result2 = $pdo->query($sql2);
                $row2 = $result2->fetch(PDO::FETCH_ASSOC);
                echo "NAJLEPSZY CZAT: " . $row2['user_name'] . " " . $row2['user_surname'] . " (" . $row['count(*)'] . ")";
              } else {
                echo "NAJLEPSZY CZAT: BRAK";
              }



              ?>

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

          <script>
            const folderPath = 'users/<?php echo $_SESSION['id']; ?>';
            let usedSpace;

            async function getFolderSize(path) {
              try {
                const response = await fetch(`get-folder-size.php?path=${path}`);
                const data = await response.json();
                usedSpace = data.folderSize;
                updateChart();
              } catch (error) {
                console.error('Błąd podczas pobierania rozmiaru folderu:', error);
              }
            }

            function updateChart() {
              const limitInMegabytes = 512; // 0,5 GB w megabajtach (1 GB = 1024 MB)
              const remainingSpace = limitInMegabytes - (usedSpace / 1024); // Konwersja użytego miejsca z kilobajtów na megabajty
              const fileSizeData = [usedSpace / 1024, remainingSpace];
              const ctx = document.getElementById('fileSizeChart').getContext('2d');
              const myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                  labels: ['USED [MB]', 'FREE [MB]'], // Zmienione etykiety na megabajty
                  datasets: [{
                    data: fileSizeData,
                    backgroundColor: ['#D9D9D9', '#1b323f'],
                  }],
                },
                options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  legend: {
                    position: 'bottom',
                  },
                },
              });
            }

            document.addEventListener('DOMContentLoaded', () => {
              getFolderSize(folderPath);
            });
          </script>

        </div>

        <div id="krecha"></div>

        <div id="left">

          <form method="POST" action='update_user.php?id=<?php echo $id; ?>'>

            <div id="imie_block">

              <div id="user_imie">Imię:</div>
              <input type="text" id="input_imie" name="name"
                placeholder="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Uzupełnij imie'; ?>">

            </div>

            <div id="nazwisko_block">

              <div id="user_nazwisko">Nazwisko:</div>
              <input type="text" id="input_nazwisko" name="surname"
                placeholder="<?php echo isset($_SESSION['surname']) ? $_SESSION['surname'] : 'Uzupełnij nazwisko'; ?>">

            </div>

            <div id="uczelnia_block">

              <div id="user_uczelnia">Uczelnia:</div>
              <select id="input_uczelnia" name="uczelnia">

                <?php

                $sql = "SELECT * FROM universities";
                $result = $pdo->query($sql);

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $selected = ($_SESSION['check_uni'] == $row['id_universities']) ? 'selected' : '';
                  echo '<option ' . $selected . ' value="' . $row["id_universities"] . '">' . $row["name_univeristy"] . '</option>';
                }

                ?>
              </select>

            </div>

            <div id="kierunek_block">

              <div id="user_kierunek">Kierunek:</div>
              <select id="input_kierunek" name="kierunek">
                <?php

                $sql = "SELECT * FROM majors";
                $result = $pdo->query($sql);

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $selected = ($_SESSION['check_maj'] == $row['id_major']) ? 'selected' : '';
                  echo '<option ' . $selected . ' value="' . $row["id_major"] . '">' . $row["major_name"] . '</option>';
                }

                ?>
              </select>

            </div>

            <div id="email_block">

              <div id="user_email">Email:</div>
              <input type="text" id="input_email" name="email" placeholder="<?php echo $_SESSION['email']; ?>">

            </div>

            <input type="submit" name="update_user" value="ZAPISZ ZMIANY" id="save">

          </form>

        </div>

        <div id="kreska"></div>

        <div id="right">

          <form method="POST" action="update_user.php?id=<?php echo $id; ?>">

            <div id="haslo_change">ZMIEŃ HASŁO</div>

            <div id="passwd_block">

              <div id="user_passwd">Aktualne hasło:</div>
              <input type="password" name="old_passwd" id="input_passwd"
                placeholder="&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;">

            </div>

            <div id="passwd_new_block">

              <div id="user_passwd_new">Nowe hasło:</div>
              <input type="password" name="new_passwd" id="input_passwd_new"
                placeholder="&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;">

            </div>

            <div id="passwd2_new_block">

              <div id="user_passwd_new2">Powtórz nowe hasło:</div>
              <input type="password" name="new_passwd2" id="input_passwd_new2"
                placeholder="&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;">

            </div>

            <input type="submit" name="update_user_pass" value="ZMIEŃ HASŁO" id="save_passwd">


          </form>
          <form action="okno_zgloszen.php" method="post">
            <input type="submit" name="update_user_pass" value="WYŚLIJ ZGŁOSZENIE" id="save_passwd">

          </form>
          <button onclick="confirmArchiving()" id="save_passwd">ARCHIWIZUJ KONTO</button>
          <button onclick="confirmDeletion()" id="save_passwd_red">USUŃ KONTO</button>
        </div>

      </div>
    </div>

  </div>

  <script>
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

      if (status === 'errorhaslo') {
        showPopover('Hasło musi zawierać przynajmniej 8 znaków.', false);
      } else if (status === 'githaslo') {
        showPopover('Pomyślnie zmieniono hasło.', true);
      } else if (status === 'errorhaslostare') {
        showPopover('Wprowadz poprawne aktualne hasło.', false);
      }
      window.history.replaceState(null, '', window.location.pathname);
    });
  </script>

  <script>
    function showConfirmationPopup(message, onYesCallback, onNoCallback) {
      document.getElementById('popupText').innerText = message;

      document.getElementById('yesButton').onclick = function () {
        closeConfirmationPopup();
        if (onYesCallback) onYesCallback();
      };

      document.getElementById('noButton').onclick = function () {
        closeConfirmationPopup();
        if (onNoCallback) onNoCallback();
      };

      document.getElementById('confirmationPopup').style.display = 'block';
    }

    function closeConfirmationPopup() {
      document.getElementById('confirmationPopup').style.display = 'none';
    }

    function confirmArchiving() {
      if (confirm("Czy na pewno chcesz zarchiwizować swoje konto?")) {
        // User clicked "Yes", send AJAX request to execute PHP code
        $.ajax({
          url: 'archive_account.php', // Replace with your PHP script's file path
          method: 'POST',
          success: function (response) {
            window.location.href = 'user_profile.php';
          }
        });
      }
    }

    function confirmDeletion() {
      if (confirm("Czy na pewno chcesz usunąć swoje konto?")) {
        // User clicked "Yes", send AJAX request to execute PHP code
        $.ajax({
          url: 'delete_account.php', // Replace with your PHP script's file path
          method: 'POST',
          success: function (response) {
            window.location.href = 'user_profile.php';
          }
        });
      }
    }
  </script>

</body>

</html>