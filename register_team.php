<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamName = $_POST['team_name'] ?? '';
    $game = $_POST['game'] ?? '';
    $captain = $_POST['captain'] ?? '';

    if (!empty($teamName) && !empty($game) && !empty($captain)) {
        addTeam($teamName, $game, $captain);
    } else {
        echo "<p class='error'>Semua field harus diisi!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Daftar Tim Baru</h1>
    <nav>
        <a href="index.php">Beranda</a> |
        <a href="manage_teams.php">Kelola Tim</a>
    </nav>
    <hr>
    <form method="POST">
        <label for="team_name">Nama Tim:</label>
        <input type="text" id="team_name" name="team_name" required><br>

        <label for="game">Game yang Dimainkan:</label>
        <input type="text" id="game" name="game" required><br>

        <label for="captain">Nama Kapten:</label>
        <input type="text" id="captain" name="captain" required><br>

        <button type="submit">Daftarkan Tim</button>
    </form>
    <?php displayTeams(); ?>
</body>
</html>
