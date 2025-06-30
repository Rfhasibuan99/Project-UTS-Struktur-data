<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'generate_bracket') {
    $teams = readFromFile('teams.txt');
    generateBracket($teams);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bracket Turnamen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bracket Turnamen</h1>
    <nav>
        <a href="index.php">Beranda</a>
    </nav>
    <hr>
    <h3>Buat Bracket Baru</h3>
    <form method="POST">
        <input type="hidden" name="action" value="generate_bracket">
        <p>Pastikan semua tim yang ingin berpartisipasi sudah terdaftar sebelum membuat bracket.</p>
        <button type="submit">Generate Bracket</button>
    </form>
    <?php displayBracket(); ?>
</body>
</html>
