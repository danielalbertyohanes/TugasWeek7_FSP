<?php
require_once("class/cerita.php");
// proses
$mysqli = new mysqli("localhost", "root", "", "story");

if (isset($_POST['btnsubmit'])) {
    $arrData = array();
    $data['judul'] = $_POST['judul'];
    $data['paragraf'] = $_POST['paragraf'];
    $data['idusers'] =


        $story = new Cerita();

    $idmovie = $movie->insertMovie($arrData);

    //penanganan genre
    if (isset($_POST['genre'])) {
        $arr_genre = $_POST['genre'];
        $sql = "Insert Into genre_movie Values (?,?)";
        foreach ($arr_genre as $idgenre) {
            $stmt = $mysqli->prepare($sql);
            $stmt->prepare($sql);
            $stmt->bind_param("ii", $idmovie, $idgenre);
            $stmt->execute();
        }
    }

    //proses penanganan poster
    if (isset($_FILES['poster'])) {
        $sql = "Insert Into gambar (extention,idmovie) Values (?,?)";

        for ($i = 0; $i < count($_FILES['poster']['tmp_name']); $i++) {
            $source = $_FILES['poster']['tmp_name'][$i];
            $ext = pathinfo($_FILES['poster']['name'][$i], PATHINFO_EXTENSION);
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $ext, $idmovie);
            $stmt->execute();
            $idgambar = $stmt->insert_id;
            $destination = "poster/$idgambar.$ext";
            move_uploaded_file($source, $destination);
        }
    }
    /*$sql = "Update movie set extention=? Where idmovie=?";
$stmt=$mysqli->prepare($sql);
$stmt->bind_param("si", $ext, $idmovie);
$stmt->execute();*/

    $stmt->close();
}

$mysqli->close();
header("location: insertstory.php");
