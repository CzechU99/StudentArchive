<!DOCTYPE html>
<html>

<head>

  <title>StudentArchive</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Styles/style_Admin.css">
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
  if (!isset($_SESSION['id']) ) {
    header('Location: log_rej.php');
    exit();
  }
  if(!($_SESSION['id'] == "admin")){
    header('Location: user_profile.php');
    exit();
  }
  ?>

  <div id="container">


    <div class="navbar">
      <p class="logo"><a href=""> Student_Archive </a></p>

      <!-- habmurger -->
      <div class="wrapper-menu" id="znikaj">
        <div class="line-menu half start"></div>
        <div class="line-menu"></div>
        <div class="line-menu half end"></div>
      </div>

      <!-- to co widac normalnie -->
      <div class="navbar-right">

        <button class="logOutButton"><a href="logOut.php"><i class="logOutIcon">&#xe802;</i></a></button>
      </div>

    </div>

    <!-- to co widac po kliknieciu -->
    <div class="hamburger-menu-expanded" id="expanded-menu">

      <div class="hamburger_row">
      </div>

      <div class="hamburger_row">
        <div id="razem_button">
          <button class="logOutButton"><a href="logOut.php"><i class="logOutIcon">&#xe802;</i></a></button>

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

    ?>
    <div id="popover" class="hidden"></div>
    <div id="bg">

      <div id="panel">

        <div id="top">

          <?php

          $query = $pdo->query("SELECT count(*) FROM `users`;"); 
          $ilosc_kont = $query->fetchColumn();

          function countFilesInDirectory($directory) {
            $fileCount = 0;
            
            $items = scandir($directory);
            
            $items = array_diff($items, ['.', '..']);
            
            foreach ($items as $item) {
                $itemPath = $directory . '/' . $item;
                
                if (is_file($itemPath)) {
                    $fileCount++;
                }
                
                if (is_dir($itemPath)) {
                    $fileCount += countFilesInDirectory($itemPath);
                }
            }
            
            return $fileCount;
          }
          $numOfFiles = countFilesInDirectory('./users');

          echo "<div id='base_inf'>";
          echo "<div id='imie'> Panel Administatora </div>";
          
          echo "<div id='status'>Liczba użytkowników:  $ilosc_kont </div>";
          echo "<div id='uczelnia'>Liczba plików: $numOfFiles </div>";
          echo "</div>";
          ?>

          

        </div>

        <div id="krecha"></div>

        <div id="left">
          <p style="margin-left: 20px; font-size: 20px; font-weight: bold;">Zgłoszenia</p>

          <table id="admin_table" style="margin-left: auto; margin-right: auto; width: 90%; border-collapse:separate; border-spacing: 0 1em;">
              <thead>
                  <tr>
                      <th>Plik</th>
                      <th>Właściciel</th>
                      <th>Zgłaszający</th>
                      <th>Wiadomość</th>
                  </tr>
              </thead>

              <tbody>

              <?php
                $query = $pdo->query("SELECT zg.zgloszenie_id AS zgloszenie_id, zg.plik, zg.sciezka, u1.user_email AS wlasciciel_email, u2.user_email AS zglaszajacy_email, zg.wiadomosc FROM zgloszenia zg JOIN users u1 ON zg.id_wlascicela = u1.user_id JOIN users u2 ON zg.id_zglaszajacego = u2.user_id;");
              

              while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                      echo "<tr>";
                      echo "<td><a href='" . htmlspecialchars($row['sciezka']) . "' dOWNLOAD>" . $row['plik'] . "</a></td>";
                      echo "<td>" . $row['wlasciciel_email'] . "</td>";
                      echo "<td>" . $row['zglaszajacy_email'] . "</td>";
                      echo "<td>" . $row['wiadomosc'] . "</td>";
                      echo "<td>
                      <form action='usun.php' method='post'>
                        <input type='hidden' name='sciezka' value='" . htmlspecialchars($row['sciezka']) . "'>
                        <input type='hidden' name='plik_id' value='" . $row['zgloszenie_id'] . "'> 
                        <input type='submit' name='usun' value='Usuń plik'>
                      </form>

                      </td>";
                      echo "<td>
                      <form action='usun_w.php' method='post'>
                        <input type='hidden' name='plik_id' value='" . $row['zgloszenie_id'] . "'> 
                        <input type='submit' name='usun' value='Usuń wpis'>
                      </form>

                      </td>";
                      echo "</tr>";
              }
              ?>

              </tbody>
          </table>

        </div>

        <div id="kreska"></div>

        <div id="right">

          <p style="margin-left: 20px; font-size: 20px; font-weight: bold;">Użytkownicy</p>

          <table id="admin_table" style="margin-left: auto; margin-right: auto; width: 90%;border-collapse:separate; border-spacing: 0 1em;">
              <thead>
                  <tr>
                      <th>E-mail</th>
                      <th>Imie</th>
                      <th>Nazwisko</th>
                  </tr>
              </thead>

              <tbody>

              <?php
                $query = $pdo->query("SELECT * FROM users;");
              

              while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                      echo "<tr style='margin-top:10px'>";
                      echo "<td><a href='serched_user_admin.php?userId=" . htmlspecialchars($row['user_id']) . "'>" . $row['user_email'] . "</a></td>";
                      echo "<td>" . $row['user_name'] . "</td>";
                      echo "<td>" . $row['user_surname'] . "</td>";
                      if($row['is_account_archived'])
                      {
                        echo "<td>
                          <form action='archiw_admin.php' method='post'>
                            <input type='hidden' name='user_id' value='" . $row['user_id'] . "'> 
                            <input type='submit' name='usun' style='background:aquamarine;' value='Aktywuj'>
                          </form>
                        </td>";
                      }
                      else
                      {
                        echo "<td>
                          <form action='archiw_admin.php' method='post'>
                            <input type='hidden' name='user_id' value='" . $row['user_id'] . "'> 
                            <input type='submit' name='usun' style='background:darkorange;' value='Zarchiwizuj'>
                          </form>
                        </td>";
                      }
                      echo "<td>
                      <form action='usun_adm.php' method='post'>
                        <input type='hidden' name='user_id' value='" . $row['user_id'] . "'> 
                        <input type='submit' name='usun' value='Usuń'>
                      </form>

                      </td>";
                      echo "</tr>";
              }
              ?>

              </tbody>
          </table>

        </div>

      </div>
    </div>
  </div>

  <script>
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
  <script>
    function showPopover(message, isSuccess) {
      var popover = document.getElementById('popover');
      popover.innerHTML = message;
      popover.style.backgroundColor = isSuccess ? '#4CAF50' : '#F44336';
      popover.style.color = '#fff';
      popover.style.display = 'block';

      setTimeout(function() {
        popover.style.display = 'none';
      }, 3000); // Ukryj popover po 3 sekundach
    }

    document.addEventListener('DOMContentLoaded', function() {
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

      document.getElementById('yesButton').onclick = function() {
        closeConfirmationPopup();
        if (onYesCallback) onYesCallback();
      };

      document.getElementById('noButton').onclick = function() {
        closeConfirmationPopup();
        if (onNoCallback) onNoCallback();
      };

      document.getElementById('confirmationPopup').style.display = 'block';
    }

    function closeConfirmationPopup() {
      document.getElementById('confirmationPopup').style.display = 'none';
    }

    function confirmArchiving() {
      if (confirm("Are you sure you want to archive your account?")) {
        // User clicked "Yes", send AJAX request to execute PHP code
        $.ajax({
          url: 'archive_account.php', // Replace with your PHP script's file path
          method: 'POST',
          success: function(response) {
            alert(response); // Display PHP script response (optional)
          }
        });
      }
    }

    function confirmDeletion() {
      if (confirm("Are you sure you want to delete your account?")) {
        // User clicked "Yes", send AJAX request to execute PHP code
        $.ajax({
          url: 'delete_account.php', // Replace with your PHP script's file path
          method: 'POST',
          success: function(response) {
            alert(response); // Display PHP script response (optional)
          }
        });
      }
    }
  </script>

</body>

</html>