<!DOCTYPE html>
<html>

<head>

    <title>StudentArchive</title>
    <meta charset="UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="Styles/style_activation.css">

    <script type="text/javascript" src="https://cdn.weglot.com/weglot.min.js"></script>
  <script>
      Weglot.initialize({
          api_key: 'wg_388361ab704ac63100f5638014b0f9b93'
      });
  </script>

</head>

<body>

    <?php


        function deleteDirectory($path) {
            if (is_dir($path)) {
                $objects = scandir($path);
                foreach ($objects as $object) {
                    if ($object != "." && $object != "..") {
                        if (is_dir($path . "/" . $object)) {
                            deleteDirectory($path . "/" . $object);
                        } else {
                            unlink($path . "/" . $object);
                        }
                    }
                }
                rmdir($path);
            }
        }


        $token = $_GET["token"];

        $token_hash = hash("sha256", $token);

        require_once 'database/db_connection.php';


        $query = "SELECT * FROM users WHERE account_activation_hash = :account_activation_hash";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':account_activation_hash', $token_hash);
        $stmt->execute();
        $result = $stmt->fetch(mode: PDO::FETCH_ASSOC);
        $id = $result["user_id"];

        if ($result === false) {
            header('Location: log_rej.php');
            exit();
        }

        $sql = "UPDATE users SET account_activation_hash = NULL WHERE user_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();


        $sql = "UPDATE users SET user_account_activation = 1 WHERE user_id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $path = "users/" . $id;
        
        if (file_exists($path))
        {
            deleteDirectory($path);
        } 

        mkdir($path);
        for ($i=1; $i < 8 ; $i++) 
        { 
            mkdir($path . "/Semestr " .$i, 0777, true);
        }



    ?>

    <div id="container">

        <div id="header">

            <div id="title"><a href="log_rej.php">Student_Archive</a></div>

        </div>

        <div id="panel">

            <div id="activation">

                <h1 id="h">WITAMY W STUDENT ARCHIVE!</h1>

                <p>Konto aktywowane! Możesz się:
                    <a href="http://localhost/P1D3-StudentArchive/log_rej.php">ZALOGOWAĆ</a>
                </p>

            </div>

        </div>
    
    </div>

</body>

</html>