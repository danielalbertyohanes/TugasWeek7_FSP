<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "story");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

$idusers = $_SESSION['idusers'];
$offset = $_GET['offset'];
$limit = $_GET['limit'];
$category = $_GET['category'];

if ($category === 'kumpulancerita') {
    $sql = "SELECT c.*, u.nama FROM cerita c INNER JOIN users u ON u.idusers = c.idusers_pembuat_awal WHERE idusers_pembuat_awal != ? LIMIT ?,?";
} elseif ($category === 'ceritaku') {
    $sql = "SELECT c.*, u.nama FROM cerita c INNER JOIN users u ON u.idusers = c.idusers_pembuat_awal WHERE idusers_pembuat_awal = ? LIMIT ?,?";
}

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sii", $idusers, $offset, $limit);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $sql_paragraf = "SELECT COUNT(*) AS total_paragraf FROM paragraf WHERE idcerita = ?";
    $stmt_paragraf = $mysqli->prepare($sql_paragraf);
    $stmt_paragraf->bind_param("i", $row['idcerita']);
    $stmt_paragraf->execute();
    $res_paragraf = $stmt_paragraf->get_result();
    $row_paragraf = $res_paragraf->fetch_assoc();

    echo "<div class='card' style='border:1px 1px solid #ccc;'>";
    echo "<h2>{$row['judul']}</h2>";
    if ($category === 'kumpulancerita') {
        echo "<h4>Pemilik Cerita: {$row['nama']}</h4>";
    } else {
        echo "<br>";
    }
    echo "<h4>Jumlah Paragraf: {$row_paragraf['total_paragraf']}</h4>";
    echo "<a href='read.php?idcerita={$row['idcerita']}'>Baca Lebih Lanjut</a>";
    echo "</div>";
}

$stmt->close();
$mysqli->close();
