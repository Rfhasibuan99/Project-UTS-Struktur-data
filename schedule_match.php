<?php
include 'functions.php';

$teams = readFromFile('teams.txt'); // Get list of registered teams

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team1Id = $_POST['team1_id'] ?? '';
    $team2Id = $_POST['team2_id'] ?? '';
    $matchTime = $_POST['match_time'] ?? '';
    $round = $_POST['round'] ?? '';

    if (empty($team1Id) || empty($team2Id) || empty($matchTime) || empty($round)) {
        echo "<p class='error'>Semua field harus diisi!</p>";
    } elseif ($team1Id === $team2Id) {
        echo "<p class='error'>Tim tidak bisa bertanding melawan dirinya sendiri!</p>";
    } else {
        addMatch($team1Id, $team2Id, $matchTime, $round);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwalkan Pertandingan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Jadwalkan Pertandingan Baru</h1>
    <nav>
        <a href="index.php">Beranda</a> |
        <a href="manage_schedule.php">Kelola Jadwal</a>
    </nav>
    <hr>
    <form method="POST">
        <label for="team1_id">Tim 1:</label>
        <select id="team1_id" name="team1_id" required>
            <option value="">Pilih Tim 1</option>
            <?php foreach ($teams as $team): ?>
                <option value="<?= htmlspecialchars($team[0]) ?>"><?= htmlspecialchars($team[1]) ?> (<?= htmlspecialchars($team[2]) ?>)</option>
            <?php endforeach; ?>
        </select><br>

        <label for="team2_id">Tim 2:</label>
        <select id="team2_id" name="team2_id" required>
            <option value="">Pilih Tim 2</option>
            <?php foreach ($teams as $team): ?>
                <option value="<?= htmlspecialchars($team[0]) ?>"><?= htmlspecialchars($team[1]) ?> (<?= htmlspecialchars($team[2]) ?>)</option>
            <?php endforeach; ?>
        </select><br>

        <label for="match_time">Waktu Pertandingan:</label>
        <input type="datetime-local" id="match_time" name="match_time" required><br>

        <label for="round">Ronde:</label>
        <input type="text" id="round" name="round" placeholder="Contoh: Babak Penyisihan, Semifinal" required><br>

        <button type="submit">Jadwalkan</button>
    </form>
    <?php displaySchedule(); ?>
</body>
</html>
