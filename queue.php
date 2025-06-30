<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean Giliran Main</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Antrean Giliran Main</h1>
    <nav>
        <a href="index.php">Beranda</a> |
        <a href="schedule_match.php">Jadwalkan Pertandingan</a>
    </nav>
    <hr>
    <?php displayQueue(); ?>
</body>
</html>
