<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Archive</title>
  <link rel="stylesheet" href="Styles/chat.css?4">
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

  <div class="content">

    <div id="user">

      <div id="return_chatroom">
        <a href="chatroom.php"><-</a>
      </div>

      <div id="user_icon">
        <i class="userIcon">&#xf2be;</i>
      </div>

      <div id="user_name">
        <?php

        require 'database/db_connection.php';

        $stmt2 = $pdo->prepare("UPDATE users SET status = 1 WHERE users.user_email = :email");
        $stmt2->bindParam(':email', $_SESSION['email']);
        $stmt2->execute();

        $sql = "SELECT * FROM users WHERE user_id = {$_GET['chat']}";

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

    <div id="msg_box">

      <?php

      $sql2 = "UPDATE messages SET displayed = 1 WHERE in_msg_id = {$_SESSION['id']} AND out_msg_id = {$_GET['chat']}";
      $stmt2 = $pdo->query($sql2);

      $sql = "SELECT * FROM messages WHERE (out_msg_id = {$_SESSION['id']} AND in_msg_id = {$_GET['chat']}) OR (out_msg_id = {$_GET['chat']} AND in_msg_id = {$_SESSION['id']})";
      $stmt = $pdo->query($sql);

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        if ($row['file'] == 0) {
          if ($row['out_msg_id'] == $_SESSION['id']) {
            echo "<div class='msg_me'>" . $row['msg_text'] . "</div>";
          } else {
            echo "<div class='msg_you'>" . $row['msg_text'] . "</div>";
          }
        } elseif ($row['file'] == 1) {
          if ($row['out_msg_id'] == $_SESSION['id']) {
            echo "<div class='msg_me'><a class='aFile' href='chatfiles/" . $row['msg_id'] . "." . pathinfo($row['msg_text'], PATHINFO_EXTENSION) . "' download='" . $row['msg_text'] . "'>" . $row['msg_text'] . "</a></div>";
          } else {
            echo "<div class='msg_you'><a class='aFileYou'  href='chatfiles/" . $row['msg_id'] . "." . pathinfo($row['msg_text'], PATHINFO_EXTENSION) . "' download='" . $row['msg_text'] . "'>" . $row['msg_text'] . "</a></div>";
          }
        }
      }

      ?>

    </div>

    <div class="kreska"></div>

    <div id="msg_input">
      <input type="number" value=<?php echo "{$_SESSION['id']}"; ?> name="in_id" class="vsb_none">
      <input type="number" value=<?php echo "{$_GET['chat']}"; ?> name="out_id" class="vsb_none">
      <textarea placeholder="Wpisz wiadomość..." id="msg_text"></textarea>
      <i onclick="fileSend()" class="pinIcon">&#xe801;</i>
      <button id="msg_send" onclick="msgSend()">Wyślij</button>
    </div>

  </div>

  <script>
    var autoScrollInterval;

    function startAutoScroll() {
      autoScrollInterval = setInterval(function() {
        var msgBox = document.getElementById("msg_box");
        msgBox.scrollTop = msgBox.scrollHeight;
      }, 1);
    }

    function stopAutoScroll() {
      clearInterval(autoScrollInterval);
    }

    var msgBox = document.getElementById("msg_box");
    msgBox.addEventListener("scroll", function() {

      if (msgBox.scrollHeight - msgBox.scrollTop === msgBox.clientHeight) {
        stopAutoScroll();
      } else {
        stopAutoScroll();
      }
    });

    msgBox.addEventListener("scroll", function() {
      if (msgBox.scrollHeight - msgBox.scrollTop === msgBox.clientHeight) {
        startAutoScroll();
      }
    });

    startAutoScroll();

    function fileSend() {
      var in_id = document.getElementsByName("in_id")[0].value;
      var out_id = document.getElementsByName("out_id")[0].value;

      var fileInput = document.createElement("input");
      fileInput.type = "file";
      fileInput.accept = "*";

      fileInput.click();

      fileInput.addEventListener("change", function() {

        var selectedFile = fileInput.files[0];
        var nameFile = selectedFile.name;

        if (selectedFile) {

          var formData = new FormData();
          formData.append("file", selectedFile);
          formData.append("in_id", in_id);
          formData.append("out_id", out_id);
          formData.append("nameFile", nameFile);

          $.ajax({
            url: "send_file.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function(data) {
              var msgBox = document.getElementById("msg_box");
              msgBox.scrollTop = msgBox.scrollHeight;
            }
          });

          document.body.removeChild(fileInput);

        }
      });
    }



    function msgSend() {

      var in_id = document.getElementsByName("in_id")[0].value;
      var out_id = document.getElementsByName("out_id")[0].value;
      var msg_text = document.getElementById("msg_text").value;

      $.ajax({
        url: "send_msg.php",
        method: "POST",
        data: {
          in_id: in_id,
          out_id: out_id,
          msg_text: msg_text
        },

        success: function(data) {
          var msgBox = document.getElementById("msg_box");
          msgBox.scrollTop = msgBox.scrollHeight;
          document.getElementById("msg_text").value = "";
        }
      });

    }

    function refreshMessages() {
      $.ajax({
        type: "GET",
        url: "refresh_messages.php",
        data: {
          chat: <?php echo "{$_GET['chat']}"; ?>
        },
        success: function(data) {
          $("#msg_box").html(data);
        }
      });
    }

    setInterval(refreshMessages, 1000);
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