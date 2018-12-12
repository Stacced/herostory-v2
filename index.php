<?php
include 'functions.php';
$actualPage = filter_input(INPUT_POST, "page", FILTER_SANITIZE_STRING);
$submitData = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);

$history = [
    "error" => [
        "header" => "Page inconnue ⚠️",
        "text" => "Cette page n'a pas encore été développée ou ne fait pas partie de l'histoire, merci de revenir à l'accueil.",
        "choices" => null,
        "submitText" => "Retourner à l'accueil",
        "submitValue" => "beginning",
        "pageImageLink" => null
    ],

    "beginning" => [
        "header" => "Bienvenue sur HeroStory V2 !",
        "text" => "Tout au long de l'histoire, vous serez confronté à des choix qui auront tous un impact sur le scénario de fin, veillez donc à faire les bons choix ou sinon... c'est une mort certaine qui" .
        " vous attend !",
        "choices" => null,
        "submitText" => "Démarrer l'histoire",
        "submitValue" => "start",
        "pageImageLink" => null
    ],

    "start" => [
        "header" => "Vous devez tout d'abord choisir entre trois héros",
        "text" => "Le choix de votre personnage impactera le déroulement de votre histoire",
        "choices" => [
            "batman" => [ "text" => "Batman", "imgLink" => "img/batman.png" ],
            "robin" => [ "text" => "Robin", "imgLink" => "img/robin.png" ],
            "joker" => [ "text" => "Joker", "imgLink" => "img/joker.jpg" ]
        ],
        "submitText" => null,
        "submitValue" => null,
        "pageImageLink" => null
    ],

    "batman" => [
        "header" => "Vous avez choisi Batman",
        "text" => "Vous vous réveillez dans la peau de Batman. Cependant, vous êtes ligoté par le Joker. Il vous garantit que si vous réussissez à le battre à un jeu, il vous laissera partir. Quel jeu choissez-vous ?",
        "choices" => [
            "rollthedice" => [ "text" => "Jouer aux dés", "imgLink" => "img/dices.jpg" ],
            "flipcoin" => [ "text" => "Jouer à pile ou face", "imgLink" => "img/coinflip.png" ]
        ],
        "submitText" => null,
        "submitValue" => null,
        "pageImageLink" => null
    ],

    "rollthedice" => [
        "header" => "Vous lancez le dé et...",
        "text" => null,
        "choices" => null,
        "submitText" => "Merci d'avoir joué !",
        "submitValue" => "beginning",
        "pageImageLink" => null
    ],

    "flipcoin" => [
        "header" => "Vous lancez la pièce en l'air et...",
        "text" => null,
        "choices" => null,
        "submitText" => "Merci d'avoir joué !",
        "submitValue" => "beginning",
        "pageImageLink" => null
    ]
];

file_put_contents("story.json", json_encode($history, JSON_UNESCAPED_UNICODE));

if (is_null($actualPage) && $submitData != 'Continuer') {
    $actualPage = "beginning";
}

if (!is_null($submitData) && $submitData != 'Continuer') {
    $actualPage = $submitData;
}

if (!array_key_exists($actualPage, $history)) {
    $actualPage = 'error';
}

/*
    LOCAL VARS ASSIGNMENT
*/

$pageHeader = $history[$actualPage]['header'];
$pageText = $history[$actualPage]['text'];
/*
$pageImageLink = array_key_exists('pageImageLink', $history[$actualPage]) ? $history[$actualPage]['pageImageLink'] : null;
$choices = array_key_exists('choices', $history[$actualPage]) ? $history[$actualPage]['choices'] : null;
$submitText = array_key_exists('submitText', $history[$actualPage]) ? $history[$actualPage]['submitText'] : null;
$submitValue = array_key_exists('submitValue', $history[$actualPage]) ? $history[$actualPage]['submitValue'] : null;
*/
$pageImageLink = is_null($history[$actualPage]['pageImageLink']) ? null : $history[$actualPage]['pageImageLink'];
$choices = is_null($history[$actualPage]['choices']) ? null : $history[$actualPage]['choices'];
$submitText = is_null($history[$actualPage]['submitText']) ? null : $history[$actualPage]['submitText'];
$submitValue = is_null($history[$actualPage]['submitValue']) ? null : $history[$actualPage]['submitValue'];

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
