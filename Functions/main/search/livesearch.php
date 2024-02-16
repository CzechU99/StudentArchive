<?php
include("../../../database/db_connection.php");

if (isset($_POST['search_input']) && $_POST['search_input'] != "") {
  $input = $_POST['search_input'];

  $query = "SELECT * FROM users WHERE user_email LIKE '{$input}%' OR user_name LIKE '{$input}%' OR user_surname LIKE '{$input}%'";
  $result = mysqli_query($db_connection, $query);

  if ($result) {
    if (mysqli_num_rows($result) > 0) {
?>
      <table>
        <thead>
          <th>Imie</th>
          <th>Nazwisko</th>
          <th>Email</th>
        </thead>

        <tbody>
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['user_name'] ?? '___';
            $surname = $row['user_surname'] ?? '___';
            $email = $row['user_email'] ?? '___';
            $id = $row['user_id'];
          ?>


            <tr>
              <td><?php echo "<a class='styled-link' href='http://localhost/P1D3-StudentArchive/serched_user.php?userId=$id'>$name</a>"; ?></td>
              <td><?php echo "<a class='styled-link' href='http://localhost/P1D3-StudentArchive/serched_user.php?userId=$id'>$surname</a>"; ?></td>
              <td><?php echo "<a class='styled-link' href='http://localhost/P1D3-StudentArchive/serched_user.php?userId=$id'>$email</a>"; ?></td>
            </tr>

          <?php } ?>
        </tbody>
      </table>
<?php
    } else {
      echo "<h6>Brak wyników</h6>";
    }
  } else {
    // Obsługa błędu zapytania
    echo "Błąd zapytania: " . mysqli_error($db_connection);
  }
}

mysqli_close($db_connection);
?>