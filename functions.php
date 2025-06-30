<?php

// Kelompok 2 :
//  1. Amira Alyana Akma(240102099)
//  2. Ananda Akhmad Hanif (240202190)
//  3. Anisa Nur Afidila (240202101)
//  4. Rifka Febiani (240102116)
//  5. Rio Fernandes Hasibuan (240202117)


// Membaca data dari file dan mengembalikannya sebagai array
function readFromFile($filename) {
    if (!file_exists($filename)) {
        return [];
    }
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return array_map(function($line) {
        return explode('|', $line);
    }, $lines);
}

function writeToFile($filename, $data) {
    $lines = array_map(function($item) {
        return implode('|', $item);
    }, $data);
    file_put_contents($filename, implode(PHP_EOL, $lines) . PHP_EOL);
}

// --- 1. Single Linked List Non-Circular (Head) – Daftar Tim Pendaftar ---

// Tambahkan Tim (Tambahkan ke akhir, secara konseptual seperti menambahkan ke daftar tertaut)
function addTeam($teamName, $game, $captain) {
    $teams = readFromFile('asset/teams.txt');
    $teamId = uniqid('team_'); // membuat id khusus untuk tim 
    $teams[] = [$teamId, $teamName, $game, $captain, 0, 0]; // ID, nama, jenis game, kapten, menang, kalah.
    writeToFile('asset/teams.txt', $teams);
    echo "<p>Tim '<strong>" . htmlspecialchars($teamName) . "</strong>' berhasil didaftarkan!</p>";
}

// Menghapus Tim
function deleteTeam($teamId) {
    $teams = readFromFile('teams.txt');
    $initialCount = count($teams);
    $updatedTeams = [];
    $found = false;

    foreach ($teams as $team) {
        if ($team[0] !== $teamId) {
            $updatedTeams[] = $team;
        } else {
            $found = true;
        }
    }

    if ($found) {
        writeToFile('asset/teams.txt', $updatedTeams);
        echo "<p>Tim dengan ID '<strong>" . htmlspecialchars($teamId) . "</strong>' berhasil dihapus.</p>";
    } else {
        echo "<p>Tim dengan ID '<strong>" . htmlspecialchars($teamId) . "</strong>' tidak ditemukan.</p>";
    }
}
// menampilkan Tim 
function displayTeams() {
    $teams = readFromFile('asset/teams.txt');
    if (empty($teams)) {
        echo "<p>Belum ada tim yang terdaftar.</p>";
        return;
    }

    echo "<h3>Daftar Tim Terdaftar:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID Tim</th><th>Nama Tim</th><th>Game</th><th>Kapten</th><th>Menang</th><th>Kalah</th></tr>";
    foreach ($teams as $team) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($team[0]) . "</td>";
        echo "<td>" . htmlspecialchars($team[1]) . "</td>";
        echo "<td>" . htmlspecialchars($team[2]) . "</td>";
        echo "<td>" . htmlspecialchars($team[3]) . "</td>";
        echo "<td>" . htmlspecialchars($team[4]) . "</td>";
        echo "<td>" . htmlspecialchars($team[5]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Mencari tim dengan ID
function getTeamById($teamId) {
    $teams = readFromFile('teams.txt');
    foreach ($teams as $team) {
        if ($team[0] === $teamId) {
            return $team;
        }
    }
    return null;
}

// Update Riwayat Tim (menang/kalah)
function updateTeamRecord($teamId, $isWinner) {
    $teams = readFromFile('teams.txt');
    $updated = false;
    foreach ($teams as &$team) { // Gunakan referensi untuk memodifikasi array secara langsung
        if ($team[0] === $teamId) {
            if ($isWinner) {
                $team[4]++; // Menang 
            } else {
                $team[5]++; // Kalah
            }
            $updated = true;
            break;
        }
    }
    if ($updated) {
        writeToFile('teams.txt', $teams);
    }
}


// --- 2. Single Linked List Non-Circular (Head & Tail) – Jadwal Pertandingan ---

// Tambahkan Match di bagian akhir (secara konseptual seperti menambahkan ke bagian ekor)
function addMatch($team1Id, $team2Id, $matchTime, $round) {
    $schedule = readFromFile('schedule.txt');
    $matchId = uniqid('match_');
    $team1Name = getTeamById($team1Id)[1] ?? 'Unknown Team';
    $team2Name = getTeamById($team2Id)[1] ?? 'Unknown Team';

    $schedule[] = [$matchId, $team1Id, $team1Name, $team2Id, $team2Name, $matchTime, $round, 'Scheduled']; // ID,ID Tim 1, Nama Tim 1,ID Tim 2,Nama Tim 2, Waktu , Ronde, Status
    writeToFile('schedule.txt', $schedule);
    echo "<p>Pertandingan antara '<strong>" . htmlspecialchars($team1Name) . "</strong>' dan '<strong>" . htmlspecialchars($team2Name) . "</strong>' pada '<strong>" . htmlspecialchars($matchTime) . "</strong>' untuk '<strong>" . htmlspecialchars($round) . "</strong>' berhasil dijadwalkan!</p>";
}

// Hapus Pertandingan (Temukan dan hapus berdasarkan ID)
function deleteMatch($matchId) {
    $schedule = readFromFile('schedule.txt');
    $updatedSchedule = [];
    $found = false;

    foreach ($schedule as $match) {
        if ($match[0] !== $matchId) {
            $updatedSchedule[] = $match;
        } else {
            $found = true;
        }
    }

    if ($found) {
        writeToFile('schedule.txt', $updatedSchedule);
        echo "<p>Jadwal pertandingan dengan ID '<strong>" . htmlspecialchars($matchId) . "</strong>' berhasil dihapus.</p>";
    } else {
        echo "<p>Jadwal pertandingan dengan ID '<strong>" . htmlspecialchars($matchId) . "</strong>' tidak ditemukan.</p>";
    }
}

// Menampilkan Semua pertandiangan 
function displaySchedule() {
    $schedule = readFromFile('schedule.txt');
    if (empty($schedule)) {
        echo "<p>Belum ada pertandingan yang dijadwalkan.</p>";
        return;
    }

    echo "<h3>Jadwal Pertandingan:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID Match</th><th>Tim 1 (ID)</th><th>Tim 1 (Nama)</th><th>Tim 2 (ID)</th><th>Tim 2 (Nama)</th><th>Waktu</th><th>Ronde</th><th>Status</th></tr>";
    foreach ($schedule as $match) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($match[0]) . "</td>";
        echo "<td>" . htmlspecialchars($match[1]) . "</td>";
        echo "<td>" . htmlspecialchars($match[2]) . "</td>";
        echo "<td>" . htmlspecialchars($match[3]) . "</td>";
        echo "<td>" . htmlspecialchars($match[4]) . "</td>";
        echo "<td>" . htmlspecialchars($match[5]) . "</td>";
        echo "<td>" . htmlspecialchars($match[6]) . "</td>";
        echo "<td>" . htmlspecialchars($match[7]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Mencari pertandingan dengan Id
function getMatchById($matchId) {
    $schedule = readFromFile('schedule.txt');
    foreach ($schedule as $match) {
        if ($match[0] === $matchId) {
            return $match;
        }
    }
    return null;
}

// Mengaupdate riwwayat pertandaingan dan rekor nya(menang/kalah)
function updateMatchResult($matchId, $winnerTeamId) {
    $schedule = readFromFile('schedule.txt');
    $updated = false;
    $winnerName = '';
    $loserName = '';

    foreach ($schedule as &$match) {
        if ($match[0] === $matchId) {
            $match[7] = 'Completed'; // fungsi Update untuk selesai 
            $match[] = $winnerTeamId; // Tambahkan ID pemenang di akhir data pertandingan
            $loserTeamId = ($match[1] === $winnerTeamId) ? $match[3] : $match[1];
            $match[] = $loserTeamId; // menambahkan ID tim yang kalah 

            $winnerName = getTeamById($winnerTeamId)[1] ?? 'Unknown Winner';
            $loserName = getTeamById($loserTeamId)[1] ?? 'Unknown Loser';

            // Update riwayat tim
            updateTeamRecord($winnerTeamId, true);
            updateTeamRecord($loserTeamId, false);

            // menambahkan kedalam riwayat
            addHistory($matchId, $match[2], $match[4], $winnerName, $loserName, $match[5], $match[6]);

            $updated = true;
            break;
        }
    }

    if ($updated) {
        writeToFile('schedule.txt', $schedule);
        echo "<p>Hasil pertandingan '<strong>" . htmlspecialchars($matchId) . "</strong>' berhasil diperbarui. Pemenang: <strong>" . htmlspecialchars($winnerName) . "</strong>.</p>";
    } else {
        echo "<p>Pertandingan dengan ID '<strong>" . htmlspecialchars($matchId) . "</strong>' tidak ditemukan.</p>";
    }
}

// --- Antrean Giliran Main (Sederhana, berdasarkan jadwal) ---
function displayQueue() {
    $schedule = readFromFile('schedule.txt');
    if (empty($schedule)) {
        echo "<p>Tidak ada pertandingan dalam antrean.</p>";
        return;
    }

    // Urutkan berdasarkan waktu untuk  antrian
    usort($schedule, function($a, $b) {
        return strtotime($a[5]) - strtotime($b[5]);
    });

    echo "<h3>Antrean Pertandingan Mendatang:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID Match</th><th>Tim 1</th><th>Tim 2</th><th>Waktu</th><th>Ronde</th><th>Status</th></tr>";
    foreach ($schedule as $match) {
        if ($match[7] === 'Scheduled') { 
            echo "<tr>";
            echo "<td>" . htmlspecialchars($match[0]) . "</td>";
            echo "<td>" . htmlspecialchars($match[2]) . "</td>";
            echo "<td>" . htmlspecialchars($match[4]) . "</td>";
            echo "<td>" . htmlspecialchars($match[5]) . "</td>";
            echo "<td>" . htmlspecialchars($match[6]) . "</td>";
            echo "<td>" . htmlspecialchars($match[7]) . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}

// --- Histori Performa ---
function addHistory($matchId, $team1Name, $team2Name, $winnerName, $loserName, $matchTime, $round) {
    $history = readFromFile('history.txt');
    $history[] = [$matchId, $team1Name, $team2Name, $winnerName, $loserName, $matchTime, $round, date('Y-m-d H:i:s')];
    writeToFile('history.txt', $history);
}

function displayHistory() {
    $history = readFromFile('history.txt');
    if (empty($history)) {
        echo "<p>Belum ada histori pertandingan.</p>";
        return;
    }

    echo "<h3>Histori Pertandingan:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID Match</th><th>Tim 1</th><th>Tim 2</th><th>Pemenang</th><th>Kalah</th><th>Waktu Match</th><th>Ronde</th><th>Waktu Catat</th></tr>";
    foreach ($history as $record) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($record[0]) . "</td>";
        echo "<td>" . htmlspecialchars($record[1]) . "</td>";
        echo "<td>" . htmlspecialchars($record[2]) . "</td>";
        echo "<td>" . htmlspecialchars($record[3]) . "</td>";
        echo "<td>" . htmlspecialchars($record[4]) . "</td>";
        echo "<td>" . htmlspecialchars($record[5]) . "</td>";
        echo "<td>" . htmlspecialchars($record[6]) . "</td>";
        echo "<td>" . htmlspecialchars($record[7]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// --- Sistem Leaderboard ---
function displayLeaderboard() {
    $teams = readFromFile('teams.txt');
    if (empty($teams)) {
        echo "<p>Belum ada tim untuk leaderboard.</p>";
        return;
    }
    usort($teams, function($a, $b) {
        if ($a[4] == $b[4]) {
            return $a[5] - $b[5];
        }
        return $b[4] - $a[4];
    });

    echo "<h3>Leaderboard Tim:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Peringkat</th><th>Nama Tim</th><th>Game</th><th>Menang</th><th>Kalah</th></tr>";
    $rank = 1;
    foreach ($teams as $team) {
        echo "<tr>";
        echo "<td>" . $rank++ . "</td>";
        echo "<td>" . htmlspecialchars($team[1]) . "</td>";
        echo "<td>" . htmlspecialchars($team[2]) . "</td>";
        echo "<td>" . htmlspecialchars($team[4]) . "</td>";
        echo "<td>" . htmlspecialchars($team[5]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// --- Jalannya Turnamen dengan Sistem Bracket (Sederhana) ---
function generateBracket($teams) {
    if (count($teams) < 2) {
        echo "<p>Minimal 2 tim diperlukan untuk membuat bracket.</p>";
        return;
    }

    //mengacak pasangan tim 
    shuffle($teams);

    $bracket = [];
    $round = 1;
    $currentTeams = $teams;

    while (count($currentTeams) > 1) {
        $roundMatches = [];
        $nextRoundTeams = [];
        $numMatches = floor(count($currentTeams) / 2);

        for ($i = 0; $i < $numMatches; $i++) {
            $team1 = array_shift($currentTeams);
            $team2 = array_shift($currentTeams);
            $matchId = uniqid('bracket_match_');
            $roundMatches[] = [
                'id' => $matchId,
                'team1_id' => $team1[0],
                'team1_name' => $team1[1],
                'team2_id' => $team2[0],
                'team2_name' => $team2[1],
                'winner_id' => null,
                'winner_name' => null,
                'round' => $round
            ];
            // Fungsi penjadwalan Tim
            addMatch($team1[0], $team2[0], 'Terjadwal', "Round " . $round);
        }

        // fungsi sistem bye apabila jumlah keseluruhan tim ganjil
        if (count($currentTeams) > 0) {
            $nextRoundTeams[] = array_shift($currentTeams); 
        }

        $bracket['Round ' . $round] = $roundMatches;
        $currentTeams = array_merge($nextRoundTeams, array_fill(0, $numMatches, ['Terjadwal', 'Pememenang pada ronde X', 'N/A', 'N/A', 0, 0])); // Placeholder untuk pemenang
        $round++;
    }

    //Struktur braket penyimpanan yang sudah disederhanakan
    file_put_contents('bracket.txt', json_encode($bracket, JSON_PRETTY_PRINT));
    echo "<p>Bracket turnamen berhasil dibuat dan dijadwalkan!</p>";
    displayBracket();
}

function displayBracket() {
    if (!file_exists('bracket.txt') || filesize('bracket.txt') == 0) {
        echo "<p>Bracket belum dibuat.</p>";
        return;
    }
    $bracket = json_decode(file_get_contents('bracket.txt'), true);

    echo "<h3>Struktur Bracket Turnamen:</h3>";
    foreach ($bracket as $roundName => $matches) {
        echo "<h4>" . htmlspecialchars($roundName) . "</h4>";
        echo "<ul>";
        foreach ($matches as $match) {
            $winnerInfo = $match['winner_name'] ? " (Winner: " . htmlspecialchars($match['winner_name']) . ")" : "";
            echo "<li>" . htmlspecialchars($match['team1_name']) . " vs " . htmlspecialchars($match['team2_name']) . $winnerInfo . " (Match ID: " . htmlspecialchars($match['id']) . ")</li>";
        }
        echo "</ul>";
    }
}

function updateBracketWinner($matchId, $winnerTeamId) {
    if (!file_exists('bracket.txt') || filesize('bracket.txt') == 0) {
        echo "<p>Bracket belum dibuat.</p>";
        return;
    }
    $bracket = json_decode(file_get_contents('bracket.txt'), true);
    $updated = false;
    $winnerName = getTeamById($winnerTeamId)[1] ?? 'Unknown Winner';

    foreach ($bracket as $roundName => &$matches) {
        foreach ($matches as &$match) {
            if ($match['id'] === $matchId) {
                $match['winner_id'] = $winnerTeamId;
                $match['winner_name'] = $winnerName;
                $updated = true;
                break 2;
            }
        }
    }

    if ($updated) {
        file_put_contents('bracket.txt', json_encode($bracket, JSON_PRETTY_PRINT));
        echo "<p>Pemenang untuk pertandingan bracket '<strong>" . htmlspecialchars($matchId) . "</strong>' berhasil diperbarui.</p>";
    } else {
        echo "<p>Pertandingan bracket dengan ID '<strong>" . htmlspecialchars($matchId) . "</strong>' tidak ditemukan.</p>";
    }
}
?>