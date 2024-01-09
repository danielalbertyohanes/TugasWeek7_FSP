<?php
require_once("class/users.php");
session_start();


if (isset($_POST['signin'])) {
	$idusers = $_POST['idusers'];
	$password = $_POST['password'];
	$users = new Users();

	if ($users->login($idusers, $password) == "sukses") {
		$_SESSION['idusers'] = $idusers;
		header("Location: home.php"); // perbaikan disini
		exit(); // pastikan untuk keluar setelah redirect
	} else {
		header("Location: index.php?error=gagal");
		exit(); // pastikan untuk keluar setelah redirect
	}
} else {
	header("Location: index.php");
	exit(); // pastikan untuk keluar setelah redirect
}
