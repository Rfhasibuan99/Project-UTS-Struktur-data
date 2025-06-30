<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $teamId = $_POST['team_id'] ?? '';
    if (!empty($teamId)) {
        deleteTeam($teamId);
    } else {
        echo "<p class='error'>ID Tim tidak boleh kosong!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Kelola Tim</h1>
    <nav>
        <a href="index.php">Beranda</a> |
        <a href="register_team.php">Daftar Tim Baru</a>
    </nav>
    <hr>
    <h3>Hapus Tim</h3>
    <form method="POST">
        <input type="hidden" name="action" value="delete">
        <label for="team_id_delete">ID Tim yang akan dihapus:</label>
        <input type="text" id="team_id_delete" name="team_id" required><br>
        <button type="submit">Hapus Tim</button>
    </form>
    <?php displayTeams(); ?>
</body>
</html>
