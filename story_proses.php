<?php
require_once("class/cerita.php");
session_start();
$mysqli = new mysqli("localhost", "root", "", "story");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

if (isset($_POST['btnSubmit'])) {
    $cerita = new Cerita();
    $idcerita = $_POST['idcerita'];
    $data = array();

    $data['paragraf'] = $_POST['paragraf'];
    if (isset($_SESSION['idusers'])) {
        $idusers = $_SESSION['idusers'];
        $data['idusers'] = $idusers;
    }
    $data['tanggal'] = date('Y-m-d H:i:s');
    $data['idcerita'] = $_POST['idcerita']; // Mengambil ID cerita dari hidden input

    $cerita->insertParagraf($data);
}
$mysqli->close();
// Setelah selesai, Anda mungkin ingin mengarahkan pengguna kembali ke halaman cerita
header("location: story.php?idcerita=" . $idcerita);
