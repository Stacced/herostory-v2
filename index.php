<?php
session_start();
include 'functions.php';

/* POST VARIABLES DECLARATION */
$actualPage = filter_input(INPUT_POST, "page", FILTER_SANITIZE_STRING);
$submitData = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);

/* STORY */
$jsonStory = file_get_contents("story.json");
$story = json_decode($jsonStory, true);

// file_put_contents("story.json", json_encode($story, JSON_UNESCAPED_UNICODE));

/* PAGE SELECTION */
if (is_null($actualPage) && $submitData != 'Continuer') {
    // First time site has been loaded => beginning page
    $actualPage = "beginning";
}

// Value attribute of submit input contains a page
if (!is_null($submitData) && $submitData != 'Continuer') {
    $actualPage = $submitData;
}

// If user submitted without choosing, redirecting to the same page
if (is_null($actualPage) && $submitData == 'Continuer') {
    $actualPage = $_SESSION['page'];
}

// If the page doesn't exist, printing an error message
if (!array_key_exists($actualPage, $story)) {
    $actualPage = 'error';
}

// Keeping page status
$_SESSION['page'] = $actualPage;

/* LOCAL VARS ASSIGNMENT */
$pageHeader = $story[$actualPage]['header'];
$pageText = $story[$actualPage]['text'];
$pageImageLink = is_null($story[$actualPage]['pageImageLink']) ? null : $story[$actualPage]['pageImageLink'];
$choices = is_null($story[$actualPage]['choices']) ? null : $story[$actualPage]['choices'];
$submitText = is_null($story[$actualPage]['submitText']) ? null : $story[$actualPage]['submitText'];
$submitValue = is_null($story[$actualPage]['submitValue']) ? null : $story[$actualPage]['submitValue'];

/*
    SPECIAL PAGES CHECKS
*/

switch ($actualPage) {
    case "rollthedice":
        $diceJoker = RollTheDice(6);
        $diceBatman = RollTheDice(6);
        if ($diceBatman > $diceJoker) {
            $pageText = "Vous obtenez $diceBatman, et le Joker $diceJoker ! Pour une fois, il tient sa parole et vous laisse repartir. Victoire !";
        } else if ($diceBatman < $diceJoker) {
            $pageText = "Vous obtenez $diceBatman, et le Joker $diceJoker ! En riant comme à son habitude, il vous plonge dans un baril d'acide... Ouch.";
        } else {
            $pageText = "Vous obtenez $diceBatman, et le Joker $diceJoker ! Bien qu'étonné, il ne vous concéda pas de deuxième chance... aux requis !";
        }
        break;
    case "flipcoin":
        $flipResult = FlipTheCoin();
        if ($flipResult == "heads") {
            $pageText = "C'est face qui tombe... en vous entraînant avec dans la tombe.";
        } else {
            $pageText = "C'est pile qui tombe !  Ca vous a porté chance ! Le Joker admet sa défaite et vous libère. Victoire !";
        }
        break;
    default:
        // do nothing...
        break;
}

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
        <div id="idPageContentContainer">
            <div id="idPageHeaderContainer">
                <h2><?= $pageHeader ?></h2>
                <h3><?= $pageText ?></h3>
            </div>

            <form action="index.php" method="POST">
                <?php
                if (!is_null($pageImageLink)) {
                    echo "<img id='idPageImage' src='$pageImageLink'><br><br>";
                }

                if (!is_null($choices)) {
                    echo "<div id='idChoicesContainer'>";

                    foreach ($choices as $key => $value) {
                        $key = ucfirst($key);
                        echo "<div id=idChoiceContainer". $key ." style='width: 300px;'>";

                        if (!is_null($value['imgLink'])) {
                            echo "<figure id='idFigure". $key ."'>";
                            echo "<img src='". $value['imgLink'] ."' style='max-width: 95%' >";
                            echo "<figcaption>";
                            echo "<input type='radio' id='idRadio". $key ."' name='page' value='". lcfirst($key) ."'><label for='idRadio". $key ."'>". $value['text'] ."</label>";
                            echo "</figcaption>";
                            echo "</figure>";
                        } else {
                            echo "<div id='idPushImg'></div>";
                            echo "<input type='radio' id='idRadio". $key ."' name='page' value='". lcfirst($key) ."'><label for='idRadio". $key ."'>". $value['text'] ."</label>";
                        }

                        echo "</div>";
                    }

                    echo "</div>";
                    echo "<br>";
                }

                if (!is_null($submitText) && !is_null($submitValue)) {
                    echo "<button id='idSubmit' type=submit name='submit' value='$submitValue'>$submitText</button>";
                } else {
                    echo "<input id='idSubmit' type=submit name='submit' value='Continuer'>";
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
