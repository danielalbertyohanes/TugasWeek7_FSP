<?php
require_once("class/movie.php");
// proses
$mysqli = new mysqli("localhost", "root", "", "movie");

if (isset($_POST['btnsubmit'])) {
	$arrData = array();
	$data['judul'] = $_POST['judul'];
	$data['rilis'] = date("Y-m-d", strtotime($_POST['rilis']));
	$data['skor'] = $_POST['skor'];
	$data['serial'] = isset($_POST['serial']) ? 1 : 0;

	$movie = new Movie();

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
header("location: insertmovie.php");
