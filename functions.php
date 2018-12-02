<?php
$headerElements = [
    "Accueil" => "index.php",
    "Github" => "https://github.com/Stacced"
];

function GenerateHeader() {
  global $headerElements;
  echo "<header>";
  echo "<nav>";
  echo "<ul>";
  foreach ($headerElements as $key => $value) {
      echo "<li><a href='$value'>$key</a></li>";
  }
  echo "</ul>";
  echo "</nav>";
  // echo "<a href='index.php'>Accueil</a>";
  echo "<div id='idDisclaimer'>Designed by Laszlo Dindeleux</div>";
  echo "</header>";
}
