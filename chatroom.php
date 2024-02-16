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

            success: function(data) {
              $(".notifi").html(data);
            }
          });

        }

        setInterval(refreshNotifi, 100);
      </script>

      <button class="notificationButton"><a href="powiadomienia.php" data-toggle='tooltip' data-placement='top' title='Powiadomienia'><i class="notificationIcon">&#xf0f3;</i> </a></button>
      
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
        <button class="notificationButton"><a href="powiadomienia.php"><i class="notificationIcon">&#xf0f3;</i> </a></button>

        <button class="notificationButton">
          <a href="chatroom.php" data-toggle='tooltip' data-placement='top' title='Czat'><i class="chatIcon">&#xf4ac;</i>
            <div class="notifi"></div>
          </a>
        </button>

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

    <div class="kreska"></div>

    <div id="search_chats">
      <input id="input_search" type="text" name="search" placeholder="SZUKAJ CHAT...">
    </div>

    <div id="chats">
      <?php

      require 'database/db_connection.php';

      $sql = "SELECT * FROM users ORDER BY status DESC";
      $stmt = $pdo->query($sql);

      $sql3 = "SELECT * FROM messages WHERE in_msg_id = {$_SESSION['id']} AND out_msg_id != {$_SESSION['id']} AND displayed = 0 GROUP BY out_msg_id;";
      $stmt3 = $pdo->query($sql3);

      $to_read = array();

      while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        array_push($to_read, $row3['out_msg_id']);
      }

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        echo "<a class='link' href='chat.php?chat={$row['user_id']}'><div class='user_chat'>";

        echo "<div class='user_icon'><i class='userIcon2'>&#xf2be;</i></div>";

        echo "<div class='user_name'>";
        if ($row['user_name'] != NULL && $row['user_surname'] != NULL) {
          echo $row['user_name'] . " " . $row['user_surname'];
        } else {
          echo $row['user_email'];
        }
        echo "</div>";

        echo "<div class='last_msg'>";

        $sql2 = "SELECT * FROM messages WHERE (out_msg_id = {$_SESSION['id']} AND in_msg_id = {$row['user_id']}) OR (out_msg_id = {$row['user_id']} AND in_msg_id = {$_SESSION['id']}) ORDER BY msg_id DESC LIMIT 1";

        $stmt2 = $pdo->query($sql2);

        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        if (!empty($row2)) {
          if (in_array($row['user_id'], $to_read)) {
            echo "<div class='msg_text2'>" . $row2['msg_text'] . "</div>";
          } else {
            echo $row2['msg_text'];
          }
        } else {
          echo "Rozpocznij waszą pierwszą rozmowę!";
        }

        echo "</div>";

        if ($row['status'] == 1) {
          echo "<div class='dot_place2'><div class='green_dot2'>&#x2022;</div></div>";
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
    function refreshChats() {

      var input = document.getElementById("input_search").value;

      $.ajax({
        url: "refresh_users.php",
        method: "GET",
        data: {
          text: input,
        },

        success: function(data) {
          $("#chats").html(data);
        }
      });

    }

    setInterval(refreshChats, 500);

    $(document).ready(function() {
      $("#input_search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".user_chat").filter(function() {
          var isHidden = $(this).text().toLowerCase().indexOf(value) === -1;
          $(this).toggle(!isHidden);
          $(this).next(".kreska").toggle(!isHidden);
        });
      });
    });
  </script>

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

</body>

</html>