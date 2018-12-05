<?php
include 'functions.php';
$actualPage = filter_input(INPUT_POST, "page", FILTER_SANITIZE_STRING);
$submitData = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);

$history = [
    "error" => [
        "header" => "Page inconnue /!\\",
        "text" => "Cette page n'a pas encore été développée ou ne fait pas partie de l'histoire, merci de revenir à l'accueil."
    ],

    "beginning" => [
        "header" => "Bienvenue sur HeroStory V2 !",
        "text" => "Tout au long de l'histoire, vous serez confronté à des choix qui auront tous un impact sur le scénario de fin, veillez donc à faire les bons choix ou sinon... c'est une mort certaine qui" .
        " vous attend !",
        "submitText" => "Démarrer l'histoire",
        "submitValue" => "start"
    ],

    "start" => [
        "header" => "Vous arrivez en ville",
        "text" => "lolololoolooololololololol",
        "choices" => [
            "left" => "Aller à gauche",
            "right" => "Aller à droite"
        ]
    ]
];

if (!isset($actualPage) && $submitData != 'Continuer') {
    $actualPage = "beginning";
}

if (isset($submitData) && $submitData != 'Continuer') {
    $actualPage = $submitData;
}

if (!array_key_exists($actualPage, $history)) {
    $actualPage = 'error';
}

// $actualPage = isset($actualPage) ? $actualPage : "beginning";
// echo $actualPage;
$pageHeader = $history[$actualPage]['header'];
$pageText = $history[$actualPage]['text'];
$choices = array_key_exists('choices', $history[$actualPage]) ? $history[$actualPage]['choices'] : null;
$submitText = array_key_exists('submitText', $history[$actualPage]) ? $history[$actualPage]['submitText'] : null;
$submitValue = array_key_exists('submitValue', $history[$actualPage]) ? $history[$actualPage]['submitValue'] : null;

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>HeroStory V2 | PHP Project</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?= GenerateHeader() ?>
        <div id="idQuestion">
            <h2><?= $pageHeader ?></h2>
            <h3><?= $pageText ?></h3>
            <form action="index.php" method="POST">
                <?php

                if (isset($choices)) {
                    foreach ($choices as $key => $value) {
                        echo "<input type='radio' id='idRadio". $key ."' name='page' value='$key'><label for='idRadio". $key ."'>$value</label>";
                    }
                }

                if (isset($submitText) && isset($submitValue)) {
                    echo "<button type=submit name='submit' value='$submitValue'>$submitText</button>";
                } else {
                    echo "<input type=submit name='submit' value='Continuer'>";
                }
                ?>

                <?php
                /*
                if (isset($leftImage) && isset($rightImage)) {
                    echo "<div id='idImgContainer'>";
                    echo "<img id='id$leftImage' src='$leftImage' alt='$leftImage'>";
                    echo "<img id='id$rightImage' src='$rightImage' alt='$rightImage'>";
                    echo "</div>";
                    echo "<br>";

                    echo "<div id='idRadioContainer'>";
                    echo "<input type=radio id='idRadioLeft' name='choice' value='$leftChoice'><label for='idRadioLeft'>$leftText</label>";
                    echo "<input type=radio id='idRadioRight' name='choice' value='$rightChoice'><label for='idRadioRight'>$rightText</label>";
                    echo "</div>";
                    echo "<br>";
                }
                */
                ?>
            </form>
        </div>
    </body>
</html>
