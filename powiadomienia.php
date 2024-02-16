<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Archive</title>
  <link rel="stylesheet" href="Styles/chatroom.css?3">
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="Functions/main/selectedFolder/selectedFolder.js"></script>
  <script src="Functions/FileEditing/deleteFile.js"></script>

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

      <button class="userButton" data-toggle='tooltip' data-placement='top' title='Profil użytkownika'>
        <a href="user_profile.php"><i class="userIcon">&#xf2be;</i></a>
      </button>

      <button class="notificationButton"><a href="chatroom.php"><i class="chatIcon">&#xf4ac;</i>
          <div class="notifi"></div>
        </a></button>

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

      <button class="notificationButton"><i class="notificationIcon" data-toggle='tooltip' data-placement='top' title='Powiadomienia'>&#xf0f3;</i></button>

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
        <button class="notificationButton"><i class="notificationIcon">&#xf0f3;</i></button>
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

  <div class="content">

    <div id="user">

      <div id="user_icon">
        <i class="userIcon">&#xf2be;</i>
      </div>

      <div id="user_name">
        <?php
        require 'database/db_connection.php';

        $stmt2 = $pdo->prepare("UPDATE users SET status = 1 WHERE users.user_email = :email");
        $stmt2->bindParam(':email', $_SESSION['email']);
        $stmt2->execute();

        $sql = "SELECT * FROM users WHERE user_id = {$_SESSION['id']}";

        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['user_name'] == "" && $row['user_surname'] == "") {
          echo $row['user_email'];
        } else {
          echo $row['user_name'] . " " . $row['user_surname'];
        }
        ?>
      </div>

      <div class="dot_place">
        <div class="green_dot">&#x2022;</div>
      </div>

    </div>

    <div id="user_name">
      Wyświetlili twój profil:
    </div>

    <div class="kreska"></div>

    <div id="chats">
      <?php

      require 'database/db_connection.php';

      $sql3 = "SELECT * FROM views WHERE viewer_id = {$_SESSION['id']} ORDER BY view_date DESC";
      $stmt3 = $pdo->query($sql3);

      $seen_array = array();
      $time_array = array();
      $name_array = array();
      $surname_array = array();
      $email_array = array();
      $viewer_array = array();

      while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $sql = "SELECT * FROM users WHERE  user_id = {$row3['user_id']};";
        $stmt = $pdo->query($sql);
        $userResult = $stmt->fetch(PDO::FETCH_ASSOC);
        array_push($seen_array, $row3['seen']);
        array_push($time_array, $row3['view_date']);
        array_push($name_array, $userResult['user_name']);
        array_push($surname_array, $userResult['user_surname']);
        array_push($email_array, $userResult['user_email']);
        array_push($viewer_array, $row3['viewer_id']);
      }

      $arrayLength = count($seen_array);
      for ($i = 0; $i < $arrayLength; $i++) {

        echo "<a class='link triggerScriptLink' href='serched_user.php?userId={$viewer_array[$i]}' data-user-id='{$viewer_array[$i]}' data-viewer-id='{$_SESSION['id']}'><div class='user_chat'>";

        echo "<div class='user_icon'><i class='userIcon2'>&#xf2be;</i></div>";

        echo "<div class='user_name'>";
        if ($name_array[$i] != NULL && $surname_array[$i] != NULL) {
          echo $name_array[$i] . " " . $surname_array[$i];
        } else {
          echo $email_array[$i];
        }
        echo "</div>";

        echo "<div class='last_msg'>";



        echo "Wyswietlono : " . $time_array[$i];
        echo "</div>";


        if ($seen_array[$i] == 1) {
          echo "<div class='dot_place2'><div class='blue_dot2'>&#x2022;</div></div>";
        } else {
          echo "<div class='dot_place2'><div class='red_dot2'>&#x2022;</div></div>";
        }

        echo "</div>";

        echo "<div class='kreska'></div></a>";
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

  <script type="text/javascript">
    function refreshChats() {


      $.ajax({
        url: "refresh_views.php",
        method: "GET",

        success: function (data) {
          $("#chats").html(data);
        }
      });

    }

    setInterval(refreshChats, 500);

    $(document).ready(function () {
      $("#input_search").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".user_chat").filter(function () {
          var isHidden = $(this).text().toLowerCase().indexOf(value) === -1;
          $(this).toggle(!isHidden);
          $(this).next(".kreska").toggle(!isHidden);
        });
      });
    });
  </script>

  <script type="text/javascript">
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

  <script type="text/javascript">
    $(document).ready(function () {
      $(".triggerScriptLink").on("click", function (e) {
        e.preventDefault();

        // Get the data attributes
        var userId = $(this).data("user-id");
        var viewerId = $(this).data("viewer-id");

        // Make an AJAX request to your PHP script with the parameters
        $.ajax({
          url: "view_notification.php",
          method: "POST",
          data: {
            user_id: userId,
            viewer_id: viewerId
          },
          success: function (response) {
            // Handle the response from the PHP script
            console.log(response);

            console.log("KURWA JEBANA");

            // Redirect after the AJAX request is successful
            window.location.href = "serched_user.php?userId=" + userId;
          },
          error: function (xhr, status, error) {
            // Handle errors

            console.log("KURWA JEBANA");
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>
</body>

</html>