<?php  //login_proses
require_once("class/users.php");

if(isset($_POST['signin'])) {
	$idusers=$_POST['idusers'];
	$password=$_POST['password'];
	$users=new Users();

	if($users->login($idusers, $password) == "sukses") {
		header("location: index.php");
	} else {
		header("location: login.php?error=gagal");
	}
} else {
	header("location: login.php");
}
