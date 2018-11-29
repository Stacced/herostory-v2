<?php

$actualPage = filter_input(INPUT_POST, "page", FILTER_SANITIZE_STRING);

$history = [
    "beginning" => [
        "header" => "Bienvenue sur HeroStory V2 !",
        "text" => "Tout au long de l'histoire, vous serez confronté à des choix qui auront tous un impact sur le scénario de fin, veillez donc à faire les bons choix ou sinon... c'est une mort certaine qui" .
        " vous attend !",
        "submitText" => "Démarrer l'histoire"
    ],

    "start" => [
        "header" => "Tu tu utututututut",
        "text" => "lolololoolooololololololol",
        "choices" => [
            "left" => "Aller à gauche",
            "right" => "Aller à droite"
        ]
    ]
];

$actualPage = isset($actualPage) ? $actualPage : "beginning";
echo $actualPage;
$pageHeader = $history[$actualPage]['header'];
$pageText = $history[$actualPage]['text'];
$choices = isset($history[$actualPage]['choices']) ? $choices : null;

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>HeroStory V2 | PHP Project</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="idQuestion">
            <h2><?= $pageHeader ?></h2>
            <h3><?= $pageText ?></h3>
            <form action="index.php" method="POST">
                <?php
                
                if (isset($choices)) {
                    foreach ($history[$actualPage]['choices'] as $key => $value) {
                        echo "<input type='radio' id='idRadio". $key ."' name='page' value='$key'><label for='idRadio". $key ."'>$value</label>";
                    }
                }
                ?>

                <input type=submit name="submit" value="<?= $history[$actualPage]['submitText'] ?>">

                <!-- <?php
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
                ?> -->
            </form>
        </div>
    </body>
</html>
