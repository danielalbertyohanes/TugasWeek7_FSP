<?php  //login_proses
session_start();
require_once("class/users.php");

if (isset($_POST['signin'])) {
	$idusers = $_POST['idusers'];
	$password = $_POST['password'];
	$users = new Users();

	if ($users->login($idusers, $password) == "sukses") {
		header("location: home.php");
		$_SESSION['idusers'] = $idusers;
	} else {
		header("location: index.php?error=gagal");
	}
} else {
	header("location: index.php");
}
