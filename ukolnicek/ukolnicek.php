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
    $prikaz = $instanceDB->prepare("SELECT FROM poznamky WHERE id=?");
    $prikaz->execute(array($idPoznamky));
    $polePoznamky = $prikaz->fetch(PDO::FETCH_ASSOC);
    var_dump($polePoznamky);
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Úkolníček</title>
</head>

<body>
    <h1>Úkolníček</h1>

    <form action="" method="post">
        <label for="xy">Název</label>
        <input type="text" name="nazev-poznamky" id="xy" value="x">
        <textarea name="text-poznamky" id="">y</textarea>
        <button type="submit" name="vytvoreni-submit">Vytvořit</button>
    </form>
    <table border="1px">
        <th>Nazev</th>
        <th>Text poznámky</th>
        <th>Smazání</th>
        <th>Úprava</th>
        <?php

        foreach ($polePoznamek as $klic) {
            echo "<tr>
            <td> $klic[nazev]</td>
            <td> $klic[poznamka]</td>
            <td><a href='?smazat={$klic['id']}'>Smazani</a></td>
            <td><a href='?uprava={$klic['id']}'>Úprava</a></td>
            </tr>";
        };
        ?>
    </table>
    <!-- Slavnostně přísahám, že k vytvoření Úkolníčku nebyla použita umělá inteligence -->
</body>

</html>