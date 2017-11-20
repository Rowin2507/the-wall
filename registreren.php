<?php
session_start();
if(isset($_SESSION['username'])){
 header("Location: account.php");
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title>Registreren | THE WALL</title>
  <link rel="shortcut icon" href="./BESTANDEN/icon.png" type="image/x-icon">
  <meta name="theme-color" content="#8cf208">
  <link rel=stylesheet href="CSS/style.css" />
  <link rel=stylesheet href="CSS/style-registreren.css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="https://use.fontawesome.com/0eb2251b78.js"></script>
</head>

<body>
  <header>
    <div class="header_wrap">
      <div id="logo"><a href="./index.php"><img src="./BESTANDEN/logo-white.png" alt="logo" /></a></div>
        <nav>
          <h1>Menu</h1>
          <a href="./index.php">HOME</a>
            <?php
              if(isset($_SESSION['username'])) {
                  $username = $_SESSION['username'];
                  echo '<a href="./process_uitloggen.php">UITLOGGEN</a>';
                  echo '<a href="./account.php">ACCOUNT (' . $username . ')</a>';
              } else {
                  echo '<a href="./inloggen.php">INLOGGEN</a>';
                  echo '<a href="./registreren.php">REGISTREREN</a>';
              }
            ?>
          <a href="./uploaden.php" class="uploaden">UPLOADEN</a>
        </nav>
        <div id="header_menu"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </div>
  </header>

<div class="header_image">

  <div class="registreren">
    <h2><span style="letter-spacing: 3px; font-size: 26px; font-family: 'Josefin Sans', sans-serif;">REGISTREREN</span></h2>
    <form method="post" action="process_registreren.php">
      <input type="text" name="username" placeholder="Gebruikersnaam" required/>
      <p><input style="margin-top: -10px;" type="email" name="mailadres" placeholder="E-mailadres" required/>
      <p><input style="margin-top: -10px;" type="password" name="password" id="password" placeholder="Wachtwoord" minlength=5 required/>
      <p><input style="margin-top: -10px;" type="password" name="password_repeat" id="password_repeat" placeholder="Wachtwoord herhalen" minlength=5 required/>
      <p><label><span style="font-size: 15px; margin-bottom: 12px;"><input type="checkbox" required>Ik ga akkoord met de voorwaarden</span></label>
      <p><input type="submit" name="submit" value="Registreren"/>
      <p><span style="line-height: 35px;">Heb je al een account? <a href="inloggen.php">Log hier in.</a></span>
    </form>
  </div>

</div>

<footer style="margin-top: 200px;">
  <div class="footer_wrap">
    <div class="footer_section_1">
      <span>CATEGORIEËN</span>
      <p><ul>
        <li><a href="./index.php">Home</a></li>
          <?php
            if(isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo '<li><a href="./process_uitloggen.php">Uitloggen</a></li>';
                echo '<li><a href="./account.php">Account (' . $username . ')</a></li>';
            } else {
                echo '<li><a href="./inloggen.php">Inloggen</a></li>';
                echo '<li><a href="./registreren.php">Registreren</a></li>';
            }
          ?>
        <li><a href="./uploaden.php">Uploaden</a></li>
        <li><a href="./scriftelijk-advies.pdf">Schriftelijk advies</a></li>
      </ul>
    </div>

    <div class="footer_section_2">
      <span>TOP GAMES</span>
      <p><ul>
        <li><a href="./index.php">Grand Theft Auto V</a></li>
        <li><a href="./index.php">Battlefield 1</a></li>
        <li><a href="./index.php">Call of Duty: Infinite Warfare</a></li>
        <li><a href="./index.php">Counter Strike: GO</a></li>
        <li><a href="./index.php">Meer games</a></li>
      </ul>
    </div>

    <div class="footer_section_3">
      <span>GEBRUIKERS</span>
      <p>Nieuwste gebruikers:
      <ul>
        <?php
          include "config.php";

          $dbc = mysqli_connect(HOST,USER,PASS,DB) or die('Er is een fout opgetreden tijdens het verbinden met de Database!');
          $query = "SELECT username FROM users LIMIT 0, 6";
          $result = mysqli_query($dbc, $query);
          while($row = mysqli_fetch_array($result)) {
              $sel_username = $row['username'];
                echo '<li>' . $sel_username . '</li>';
            }
        ?>
      </ul>
    </div>

    <div class="footer_section_4">
      <span>CONTACT</span>
      <p>T H E &nbsp;&nbsp; W A L L
      <ul>
        <li>Amsterdam NH</li>
        <li><a href="https://www.ma-web.nl/" target="_blank">Media College</a></li>
        <li>Contactweg 36 1060 JA</li>

        <li>Rowin: <a href="mailto:23250@ma-web.nl">23250@ma-web.nl</a></li>
        <li>Luc: <a href="mailto:23924@ma-web.nl">23924@ma-web.nl</a></li>
      </ul>
    </div>

    <div class="footer_section_5">
      <img src="./BESTANDEN/logo-white.png" alt="logo_footer" />
    </div>

  </div>


  <div class="copyright-social">
    <div class="copyright-social_wrap">
      <div id="copyright"></div>
      <div class="social">SOCIAL MEDIA &nbsp;
        <a href="https://facebook.com" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <a href="https://instagram.com" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        <a href="https://snapchat.com" target="_blank"><i class="fa fa-snapchat-ghost" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
</footer>

<a href="#0" class="cd-top">Top</a>
<script src="SCRIPT/script.js"></script>
</body>
</html>
