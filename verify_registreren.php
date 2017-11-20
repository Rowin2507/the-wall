<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registreren | THE WALL</title>
    <link rel="shortcut icon" href="./BESTANDEN/icon.png" type="image/x-icon">
    <meta name="theme-color" content="#8cf208">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel=stylesheet href="CSS/style-verify-registreren.css" />
    <script src="https://use.fontawesome.com/0eb2251b78.js"></script>
</head>
<body>
<div class="body-background">
  <div class="login">
    <h2><span style="letter-spacing: 3px;">REGISTRATIE VOLTOOID</span></h2>
      <p><img style="width: 200px;" src="account.png" /></p>

      <?php
        include "config.php";

        $dbc = mysqli_connect(HOST,USER,PASS,DB) or die('Er is een fout opgetreden tijdens het verbinden met de Database!');

        $mailadres = $_GET["mailadres"];
        $hashcode = $_GET["hashcode"];

        $query = "SELECT * FROM users WHERE mailadres='$mailadres' AND hashcode='$hashcode'";
        $result = mysqli_query($dbc,$query) or die ("Fout! Query is mislukt");

        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result);
          $username = $row['username'];
          $query = "UPDATE users SET status=1 WHERE username='$username'";
          $result = mysqli_query($dbc,$query) or die ('Error updating.');
          echo '<br>Bedankt, je inschrijving is compleet!
          <p><a style="color: #8cf208;" href="inloggen.php">Klik hier om in te loggen.</a>';
        }else {
          echo'Er is een fout opgetreden tijdens het voltooien van je inschrijving.';
        }

      ?>

  </div>
</div>

</body>
</html>
