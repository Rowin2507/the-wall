<?php
session_start();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title>THE WALL</title>
  <link rel="shortcut icon" href="./BESTANDEN/icon.png" type="image/x-icon">
  <meta name="theme-color" content="#8cf208">
  <link rel=stylesheet href="CSS/style.css" />
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

<div class="header_video">
  <div class="mobiele-header-image"><img src="header-image-home.jpg"/></div>
  <video poster="header-image-home.jpg" id="bgvid" playsinline autoplay muted loop>
    <source src="./SITE-VIDEOS/Home-video.mp4" type="video/mp4">
  </video>

  <div class="header_content">
    <h1>THE WALL</h1>
    Deel jouw favoriete In-Game moment met anderen. Wall ahead of others!
    <p><a href="./uploaden.php" class="button" id="left_button">JOUW MOMENT DELEN</a>
      <?php
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo '<a href="./account.php" class="button" id="right_button">ACCOUNT</a>';
        } else {
            echo '<a href="./registreren.php" class="button" id="right_button">REGISTREREN</a>';
        }
      ?>
  </div>

  <div class="categories">
    <div class="categorie">
      <a href="http://www.rockstargames.com/" target="_blank"><img src="./SITE-AFBEELDINGEN/gtav.jpg" alt="Grand Theft Auto V" /></a>
      <span class="categorie-titel">Grand Theft Auto V</span>
    </div>
    <div class="categorie">
      <label><a href="https://www.battlefield.com/nl-nl" target="_blank"><img src="./SITE-AFBEELDINGEN/bf1.png" alt="Battlefield 1" /></a>
      <span class="categorie-titel">Battlefield 1</span></label>
    </div>
    <div class="categorie">
      <a href="https://www.callofduty.com/nl/infinitewarfare" target="_blank"><img src="./SITE-AFBEELDINGEN/cod-iw.png" alt="COD: Infinite Warfare" /></a>
      <span class="categorie-titel">COD: Infinite Warfare</span>
    </div>
    <div class="categorie">
      <a href="http://blog.counter-strike.net/" target="_blank"><img src="./SITE-AFBEELDINGEN/csgo.jpg" alt="Counter Strike: GO" /></a>
      <span class="categorie-titel">Counter Strike: GO</span>
    </div>
    <div class="categorie">
      <a href="http://store.steampowered.com/" target="_blank"><img src="./SITE-AFBEELDINGEN/games.png" alt="Meer games" /></a>
      <span class="categorie-titel">Meer games</span>
    </div>
  </div>
</div>

<div class="body-full">
<div class="body-wrap">
  <div class="zoeken">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="text" class="zoeken-text" name="searchterm" class="searchbar" placeholder="&#xf002; Zoeken op beschrijving..." required/>
      <input type="submit" name="submit_search" style="display: none">
    </form>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <select class="sorteren" name="sorteermenu" onchange="this.form.submit();" id="sorteermenu">
        <option value="">Sorteren</option>
        <option value="date_desc">Nieuwste eerst</option>
        <option value="date_asc">Oudste eerst</option>
        <option value="game_desc">Game aflopend</option>
        <option value="game_asc">Game oplopend</option>
        <option value="random">Willekeurige volgorde</option>
      </select>
    </form>
  </div>

  <h2>ALLE UPLOADS:</h2>
</div>

<div class="posts-wrap">
  <div class="posts-button" id="posts-button">
    <p><a href="uploaden.php"><img id="plus" src="plus.png" /></a>
    <div class="beschrijving">Jouw In-Game moment delen</div>
  </div>


<?php
include "config.php";

  $column = 'id';
  $sortorder = 'DESC';

  $dbc = mysqli_connect(HOST,USER,PASS,DB) or die('Er is een fout opgetreden tijdens het verbinden met de Database!');

  if(isset($_POST['submit_search'])) {
    $searchterm = mysqli_real_escape_string($dbc, trim($_POST['searchterm']));
    $searchterm = '%' . $searchterm . '%';
  } else {
    $searchterm = '%';
  }

  if(isset($_POST['sorteermenu'])) {
    switch ($_POST['sorteermenu']) {
      case 'date_desc':
        $column = 'datum';
        $sortorder = 'ASC';
      break;

      case 'date_asc':
        $column = 'datum';
        $sortorder = 'DESC';
      break;

      case 'game_desc':
        $column = 'game';
        $sortorder = 'DESC';
      break;

      case 'game_asc':
        $column = 'game';
        $sortorder = 'ASC';
      break;

      case 'random':
        $column = 'rand()';
        $sortorder = '';
      break;

    }
  }

$query = "SELECT * FROM feed WHERE beschrijving LIKE '$searchterm' ORDER BY $column $sortorder";
$result = mysqli_query($dbc, $query);
while($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    $target = $row['img'];
    $date = $row['datum'];
    $username = $row['user'];
    $game = $row['game'];
    $description = $row['beschrijving'];

    echo '<a href="#image'. $id .'" class="posts">
            <div class="posts" style="background-image:url(' . $target . ');">


    <div class="volledige-beschrijving"><i class="fa fa-quote-right" aria-hidden="true"></i>&nbsp; ' . $description . ' &nbsp;<i class="fa fa-quote-right" aria-hidden="true"></i></div>
    <div class="beschrijving">

      <strong>' . $username . '</strong>' . ' | ' . $game . '
    </div>

    </div>
    </a>

    <div class="lightbox short-animate" id="image'. $id .'">
                     <img class="long-animate" src="'. $target .'"/>
                   </div>
                   <div id="lightbox-controls" class="short-animate">
                     <a id="close-lightbox" class="long-animate" href="#!"></a>
                   </div>

    ';}
?>

  <div class="posts"></div>
  <div class="posts"></div>
  <div class="posts"></div>





</div>

</div>



<footer>
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
