<?php
require_once("class/cerita.php");
session_start();

if (isset($_POST['btnsubmit'])) {
    $cerita = new Cerita();
    $data = array();
    $data['judul'] = $_POST['judul'];
    $data['paragraf'] = $_POST['paragraf'];

    if (isset($_SESSION['idusers'])) {
        $data['idusers'] = $_SESSION['idusers'];
    } else {
        echo "Salah ID user";
        exit;
    }

    $data['tanggal'] = date('Y-m-d H:i:s');

    $idcerita = $cerita->insertCerita($data);

    if ($idcerita !== false) {
        echo "BERHASIL menyimpan cerita.";
    } else {
        echo "GAGAL menyimpan cerita.";
    }
}
header("location: insertstory.php");
