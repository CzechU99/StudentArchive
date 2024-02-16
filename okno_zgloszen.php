<!DOCTYPE html>
<html>

<head>

  <title>StudentArchive</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Styles/zgloszenia.css?3">
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

        <button class="notificationButton"><a href="powiadomienia.php"><i class="notificationIcon">&#xf0f3;</i> </a></button>
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
          <button class="notificationButton"><a href="powiadomienia.php"><i class="notificationIcon">&#xf0f3;</i> </a></button>

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


        <div id="left">
          <div id='imie'>Formularz zgłoszeniowy</div>
          <form method="POST" action='okno_zgloszen_wyslij_emial.php'>

            <div id="imie_block">

              <div id="user_imie">Temat:</div>
              <input type="text" id="input_short" name="temat" placeholder="Temat">

            </div>


            <div id="uczelnia_block">

              <div id="user_uczelnia">Kategoria:</div>
              <select id="input_uczelnia" name="kategoria">

                <?php

                $sql = "SELECT * FROM universities";
                $result = $pdo->query($sql);
                $kategorie = array("Błędy interfejsu graficznego", "Naruszenia regulaminu", "Utrata danych", "Inne");

                foreach ($kategorie as $kategoria) {
                  echo '<option value="' . $kategoria . '">' . $kategoria . '</option>';
                }

                ?>
              </select>

            </div>



            <div id="email_block" class="col-75">

              <div id="user_email">Email:</div>
              <textarea id="subject" name="wiadomosc" placeholder="Tresc emaila..." style="height:200px"></textarea>
            </div>

            <input type="submit" name="update_user" value="Wyślij zgłoszenie" id="save">

          </form>
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