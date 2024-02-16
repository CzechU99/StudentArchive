<?php
session_start();
if (isset($_SESSION['id'])) {
  header('Location: main.php');
}
?>

<!DOCTYPE html>
<html>

<head>

  <title>StudentArchive</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Styles/style_log.css?3">
  <link rel="stylesheet" href="Styles/validation.css">
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="rejestracja_walidacja.js"></script>

  <script type="text/javascript" src="https://cdn.weglot.com/weglot.min.js"></script>
  <script>
    Weglot.initialize({
      api_key: 'wg_388361ab704ac63100f5638014b0f9b93'
    });
  </script>

</head>

<body>

  <div id="container">

    <div id="header">

      <div id="title">Student_Archive</div>

    </div>

    <div id="panel">

      <div id="popover" class="hidden"></div>

      <form action="login.php" method="post">
        <div id="logowanie">

          <div id="log_tekst">Logowanie</div>

          <div id="log_email">E-MAIL:</div>
          <input id="log_email_input" type="email" name="email" placeholder="Podaj e-mail...">

          <div id="log_haslo">HASŁO:</div>
          <input id="log_haslo_input" type="password" name="passwd" placeholder="Podaj haslo...">

          <div id="log_przyciski">
            <input id="log_przycisk_zaloguj" type="submit" value="ZALOGUJ">
          </div>


          <div id="krecha"></div>

          <a href="recover-password/forgot-password.php">
            <div id="reset">RESETUJ HASŁO</div>
          </a>

        </div>
      </form>

      <div id="kreska"></div>

      <div id="rejestracja">
        <div id="rej_tekst">Rejestracja</div>
        <form method="POST" action="registerHandler.php" onsubmit="return validateForm();">
          <div id="rej_email">E-MAIL:</div>
          <input id="rej_email_input" type="email" name="email" placeholder="Podaj e-mail..." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required title="Podaj prawidłowy adres e-mail">

          <div id="rej_haslo">HASŁO:</div>
          <input id="rej_haslo_input" type="password" name="haslo" placeholder="Podaj hasło..." required pattern="(?=.*?[A-Z])(?=.*?[a-z])(?=.*\W).{8,}" title="Hasło musi zawierać co najmniej 8 znaków, małą i dużą literę oraz znak specjalny">

          <div id="rej_haslo2">Powtórz hasło:</div>
          <input id="rej_haslo2_input" type="password" name="haslo2" placeholder="Powtórz hasło..." required title="To pole jest obowiązkowe">

          <div id="rej_uczelnia">Uczelnia:</div>
          <select id="rej_uczelnia_input" name="uczelnia" required title="Wybierz uczelnię z listy">
            <option value="" disabled selected>Wybierz uczelnię...</option>
            <option value="1">Politechnika Opolska</option>
            <option value="3">Uniwersytet Opolski</option>
            <option value="4">Politechnika Wrocławska</option>
            <option value="2">Uniwersytet Wrocławski</option>
          </select>

          <div id="captcha" class="g-recaptcha" data-sitekey="6LfTHyEpAAAAAESKLz2KMX8W-GiWoL8GVAyhHmHN"></div>

          <div id="rej_przyciski">

            <input id="rej_przycisk_zarejestruj" type="submit" value="ZAREJESTRUJ">
          </div>
        </form>
      </div>

    </div>

  </div>

  </div>


  <script src="rejestracja_walidacja.js"></script>

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

      if (status === 'success') {
        showPopover('Zakończono pomyślnie! Pamiętaj, żeby potwierdzić adres email', true);
      } else if (status === 'error') {
        showPopover('Coś poszło nie tak uzupełnij formularz ponownie', false);
      } else if (status === 'errorCaptcha') {
        showPopover('Weryfikacja Captcha nie powiodła się, spróbuj ponownie', false);
      } else if (status === 'errorNoCaptcha') {
        showPopover('Potwierdz ze nie jesteś robotem', false);
      } else if (status === 'errorEmail') {
        showPopover('Konto z podanym adresem email już istnieje.', false);
      } else if (status === 'errorhaslo') {
        showPopover('Podano błędne hasło lub email.', false);
      } else if (status === 'errorlogin') {
        showPopover('Nie podano e-mail\'a', false);
      } else if (status === 'udanaZmianaHasla') {
        showPopover('Pomyślnie zmieniono hasło!', true);
      }
      window.history.replaceState(null, '', window.location.pathname);
    });
  </script>

</body>

</html>