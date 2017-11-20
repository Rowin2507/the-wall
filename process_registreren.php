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
    <link rel=stylesheet href="CSS/style-process-registreren.css" />
    <script src="https://use.fontawesome.com/0eb2251b78.js"></script>

</head>
<body>
<div class="header_image">
  <div class="login">
    <h2><span style="letter-spacing: 3px;">REGISTRATIE BEVESTIGING</span></h2>
      <p><img style="width: 200px;" src="mail.png" /></p>

    <?php
      include "config.php";

      $dbc = mysqli_connect(HOST,USER,PASS,DB) or die('Er is een fout opgetreden tijdens het verbinden met de Database!');

      if (!isset($_POST['submit'])) {
        echo 'Sorry, je hoort hier niet te zijn <p>';
        echo '<a style="color: #8cf208;" href="registreren.php">Klik hier om een account aan te maken.</a>';
        exit();
      }

      $username = mysqli_real_escape_string($dbc,trim($_POST['username']));

      if (isset($_POST['submit'])){
      $check=mysqli_query($dbc,"SELECT * FROM users WHERE username='$username'");
      $checkrows=mysqli_num_rows($check);

     if($checkrows>0) {
        echo 'Een account met gebruikersnaam <strong>'. $username . '</strong> bestaat al.
              <p><a style="color: #8cf208;" href="registreren.php">Klik hier om een ander account aan te maken</a>';
        exit();
     } else {


      $mailadres = mysqli_real_escape_string($dbc,trim($_POST['mailadres']));
      $password = mysqli_real_escape_string($dbc,trim($_POST['password']));
      $hashed_password = hash('sha512', $password);

      $random_number = rand(1000, 9999);
      $hashcode = hash('sha512', $random_number);

      $query = "INSERT INTO users
                VALUES (0,'$username','$hashed_password','$mailadres','$hashcode',0)";
      $result = mysqli_query($dbc,$query) or die ('Error inserting user.');


      $to = $_POST ['mailadres'];
      $subject = 'Instaclone activatie';
      $msg = '
        <html>
        <head>
          <title>Instaclone account activatie</title>
          <style>
            body {margin: 0 auto; font-family: sans-serif; background: #E6E6E6; color: #000; text-align: center;}
            table.logo {margin: 50px auto; text-align: center;}
            table.content {margin: 0 auto; text-align: center;}
            a {color: #8cf208; text-decoration: none;}
          </style>
        </head>

        <body style="margin: 0 auto; font-family: sans-serif; background: #E6E6E6; color: #000; text-align: center;">
          <table class="logo" cellspacing="0" style="background: #fff; width: 600px; padding: 25px; border-radius: 8px;">
            <tr><a href="http://the-wall.pe.hu/"><img style="width: 50%;" src="http://23250.hosts.ma-cloud.nl/the-wall/BESTANDEN/logo-mail.png" /></a></td>
            </tr>
          </table>

          <table class="content" cellspacing="0" style="background: #fff; width: 600px; height: 750px; padding: 25px; border-radius: 8px;">
            <tr>
              <p><p><p><p><span style="font-size: 20px;">Welkom bij THE WALL <strong><span style="color: #8cf208;">'. $username .'</span></strong></span>
              <p>Om je account te activeren moet je op de onderstaande link klikken</p>
              <a href="http://the-wall.pe.hu/verify_registreren.php?mailadres=' . $mailadres . '&hashcode=' . $hashcode . '">Klik hier om je e-mail te bevestigen</a>
            </tr>
            <tr>
              <p>Copyright © 2017 - THE WALL | MediaCollege | MD1A
            </tr>
          </table>

        </body>
        </html>
        ';

      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $headers .= 'From: activatie@thewall.nl' . "\r\n";
      $headers .= '' . "\r\n";

      if (mail($to, $subject, $msg, $headers))
      {
        echo ('<p>Er is een bevestigingsmail verzonden naar <span style="color: #8cf208;"><strong>' . $mailadres . '</strong></span><p>Volg daar de instructies om je accountregistratie te voltooien</p>');
      }
      else {
        echo ('<p>Er is een fout opgetreden tijdens het verzenden van de mail. <a href="registreren.php">Probeer het hier opnieuw.</a>');
      }


    }
    };

    ?>

  </div>
</div>

</body>
</html>
