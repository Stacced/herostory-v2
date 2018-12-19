<?php
$headerElements = [
    "Accueil" => "index.php",
    "Github V1" => "https://github.com/Stacced/herostory",
    "Github V2" => "https://github.com/Stacced/herostory-v2",
    "CFPTi" => "https://edu.ge.ch/site/cfpt-informatique/"
  ];

function GenerateHeader() {
    global $headerElements; // récupère la variable de scope globale
    echo "<header>";
    echo "<img src='img/batman.png' draggable=false id='idBatmanLeft'>";
    echo "<nav>";
    echo "<ul>";
    foreach ($headerElements as $key => $value) {
        echo "<li><a href='$value'>$key</a></li>";
    }
    echo "</ul>";
    echo "</nav>";
    echo "<img src='img/batman.png' draggable=false id='idBatmanRight'>";
    echo "<div id='idDisclaimer'>Designed by Laszlo Dindeleux</div>";
    echo "</header>";
}

function GenerateFooter() {
    echo "<footer>";
    echo "<div id='idDisclaimer'>Designed by Laszlo Dindeleux</div>";
    echo "</footer>";
}

function RollTheDice($sides) {
    return rand(1, $sides);
}

function FlipTheCoin() {
    $result = "";
    $forCount = 0;
    for ($i=0; $i < 500; $i++) {
        $forCount += rand(1, 500);
    }

    if ($forCount / 500 >= 250) {
        $result = "heads";
    } else {
        $result = "tails";
    }

    return $result;
}
