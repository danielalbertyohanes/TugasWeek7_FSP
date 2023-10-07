<?php  //login_proses
require_once("class/users.php");

if(isset($_POST['signin'])) {
	$userid=$_POST['userid'];
	$password=$_POST['password'];
	$users=new Users();

	if($users->login($userid, $password) == "sukses") {
		header("location: index.php");
	} else {
		header("location: login.php?error=gagal");
	}
} else {
	header("location: login.php");
}

?>