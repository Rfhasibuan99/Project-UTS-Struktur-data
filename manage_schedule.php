<?php
include 'functions.php';

$schedule = readFromFile('schedule.txt'); // Get current schedule

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $matchId = $_POST['match_id_delete'] ?? '';
        if (!empty($matchId)) {
            deleteMatch($matchId);
        } else {
            echo "<p class='error'>ID Pertandingan tidak boleh kosong!</p>";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update_result') {
        $matchId = $_POST['match_id_result'] ?? '';
        $winnerTeamId = $_POST['winner_team_id'] ?? '';
        if (!empty($matchId) && !empty($winnerTeamId)) {
            updateMatchResult($matchId, $winnerTeamId);
            updateBracketWinner($matchId, $winnerTeamId); // Update bracket if this match is part of it
        } else {
            echo "<p class='error'>ID Pertandingan dan Pemenang harus diisi!</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal Pertandingan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Kelola Jadwal Pertandingan</h1>
    <nav>
        <a href="index.php">Beranda</a> |
        <a href="schedule_match.php">Jadwalkan Pertandingan Baru</a>
    </nav>
    <hr>
    <h3>Hapus Jadwal Pertandingan</h3>
    <form method="POST">
        <input type="hidden" name="action" value="delete">
        <label for="match_id_delete">ID Pertandingan yang akan dihapus:</label>
        <input type="text" id="match_id_delete" name="match_id_delete" required><br>
        <button type="submit">Hapus Jadwal</button>
    </form>

    <h3>Perbarui Hasil Pertandingan</h3>
    <form method="POST">
        <input type="hidden" name="action" value="update_result">
        <label for="match_id_result">ID Pertandingan:</label>
        <input type="text" id="match_id_result" name="match_id_result" required><br>

        <label for="winner_team_id">Pemenang (ID Tim):</label>
        <input type="text" id="winner_team_id" name="winner_team_id" placeholder="Masukkan ID Tim Pemenang" required><br>
        <button type="submit">Perbarui Hasil</button>
    </form>

    <?php displaySchedule(); ?>
</body>
</html>
