<?php
$instanceDB = new PDO(
    "mysql:host=127.0.0.1:3306;dbname=ukolnicek;charset=utf8mb4",
    "root",
    "",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$prikaz = $instanceDB->prepare("SELECT * FROM poznamky");
$prikaz->execute(array());
$polePoznamek = $prikaz->fetchAll(PDO::FETCH_ASSOC);

if (array_key_exists("vytvoreni-submit", $_POST)) {
    $nazevPoznamky = trim($_POST["nazev-poznamky"]);
    $textPoznamky = trim($_POST["text-poznamky"]);
    $prikaz = $instanceDB->prepare("INSERT INTO poznamky SET nazev=?, poznamka=?");
    $prikaz->execute(array($nazevPoznamky, $textPoznamky));
    header("Location: ?");
}

if (array_key_exists("smazat", $_GET)) {
    $idPoznamky = $_GET["smazat"];
    $prikaz = $instanceDB->prepare("DELETE FROM poznamky WHERE id=?");
    $prikaz->execute(array($idPoznamky));
    header("Location: ?");
}

if (array_key_exists("uprava", $_GET)) {
    $idPoznamky = $_GET["uprava"];
    $prikaz = $instanceDB->prepare("SELECT * FROM poznamky WHERE id=?");
    $prikaz->execute(array($idPoznamky));
    $polePoznamky = $prikaz->fetch(PDO::FETCH_ASSOC);
    $nazevPoznamky = $polePoznamky["nazev"];
    $textPoznamky = $polePoznamky["poznamka"];
}

if (array_key_exists("uprava-submit", $_POST)) {
    $nazev = trim($_POST["uprava-nazev"]);
    $text = trim($_POST["uprava-text"]);
    $prikaz = $instanceDB->prepare("UPDATE poznamky SET nazev=?, poznamka=?");
    $prikaz->execute(array($nazev, $text));
    header("Location: ?");
}

if (array_key_exists("zrusit-upravu-submit", $_POST)) {
    header("Location: ?");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Úkolníček</title>
    <style>
        body {
            justify-content: center;
        }

        .container {
            text-align: center;
        }

        h1 {
            text-align: center;
        }

        .seznam .center {
            align-items: center;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }

        #xy {
            font-weight: bold;
        }

        .container input[type="text"],
        .container textarea {
            width: 25%;
        }

        img {
            width: 13px;
            height: auto;
        }

    </style>
</head>

<body>
    <h1>Úkolníček</h1>
    <div class="container">
        <form action="" method="post">
            <input type="text" name="nazev-poznamky" placeholder="Název" width="150px">
            <br>
            <textarea name="text-poznamky" rows='5'></textarea>
            <br>
            <button type="submit" name="vytvoreni-submit">Vytvořit</button>
        </form>
    </div>
    <div class="seznam">
        <table class="center">
            <?php
            if (array_key_exists("uprava", $_GET)) {
                echo "<tr> <form method='post'>
                <td> <input type='text' name='uprava-nazev' value='$nazevPoznamky'> </td>
                <td> <textarea name='uprava-text'>$textPoznamky</textarea></td>
                <td> <button type='submit' name='uprava-submit'><img src='./img/pencil.png'></button></td>
                <td> <button type='submit' name='zrusit-upravu-submit'><img src='./img/close.png'></button></td></form>";
            };
            foreach ($polePoznamek as $klic) {
                echo "<tr>
                <td id='xy'> $klic[nazev]</td>
                <td> $klic[poznamka]</td>
                <td><a href='?smazat={$klic['id']}'><img src='./img/trash_bin.png'></a></td>
                <td><a href='?uprava={$klic['id']}'><img src='./img/pencil.png'></a></td>
                </tr>";
            };

            ?>
        </table>
    </div>
    <!-- Slavnostně přísahám, že k vytvoření Úkolníčku nebyla použita umělá inteligence -->
</body>

</html>