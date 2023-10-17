<?php
session_start();
require_once("class/cerita.php");

// proses
$mysqli = new mysqli("localhost", "root", "", "story");

if (isset($_POST['btnsubmit'])) {
    $cerita = new Cerita();
    $data = array(); // Menggunakan $data bukan $arrData
    $data['judul'] = $_POST['judul'];
    $data['paragraf'] = $_POST['paragraf'];

    // Periksa apakah 'idusers' sudah tersedia di dalam sesi
    if (isset($_SESSION['idusers'])) {
        $data['idusers'] = $_SESSION['idusers'];
    } else {
        echo "Salah ID user";
        // Tangani jika 'idusers' tidak tersedia dalam sesi
        exit; // Hentikan eksekusi skrip
    }

    $data['tanggal'] = date('Y-m-d H:i:s');

    // Periksa apakah cerita berhasil dimasukkan
    $idcerita = $cerita->insertCerita($data);

    if ($idcerita !== false) { // Periksa apakah idcerita valid
        echo "BERHASIL menyimpan cerita.";
    } else {
        echo "GAGAL menyimpan cerita.";
        // Tangani kesalahan penyimpanan cerita
    }
}

$mysqli->close();
header("location: insertstory.php");
