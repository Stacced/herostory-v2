<?php
$headerElements = [
    "Accueil" => "index.php",
    "Github" => "https://github.com/Stacced",
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
